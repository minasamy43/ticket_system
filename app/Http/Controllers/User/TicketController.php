<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    public function create()
    {
        return view('user.create-ticket');
    }

    public function show($id)
    {
        $ticket = Ticket::with([
            'user',
            'replies' => function ($q) {
                $q->with('admin', 'user')->oldest();
            }
        ])->withCount([
                    'replies as unread_replies_count' => function ($query) {
                        $query->whereNotNull('admin_id')->where('is_read', 0);
                    }
                ])->findOrFail($id);

        if ($ticket->user_id !== Auth::id() && Auth::user()->role != 1) {
            abort(403, 'Unauthorized');
        }

        if (Auth::user()->role == 1) {
            return view('admin.show-ticket', compact('ticket'));
        }

        // User doesn't want to mark as read when full page is opened, only when icon is clicked
        // if (!$ticket->has_user_read) {
        //     $ticket->update(['has_user_read' => true]);
        // }
        // $ticket->replies()->whereNotNull('admin_id')->where('is_read', false)->update(['is_read' => true]);

        return view('user.show-ticket', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'body' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if (!$request->body && !$request->hasFile('image')) {
            return back()->with('error', 'Message or image is required.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = date('Y-m-d_(H-i)') . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('tickets', $filename, 'public');
        }

        $reply = \App\Models\Reply::create([
            'ticket_id' => $id,
            'user_id' => Auth::id(),
            'admin_id' => null,
            'body' => $request->body ?? '',
            'image' => $imagePath,
        ]);

        // Mark as unread for the admin
        Ticket::where('id', $id)->update(['has_admin_read' => false]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Reply sent.',
                'reply' => [
                    'body' => $reply->body,
                    'is_admin' => false,
                    'image' => $reply->image ? asset('storage/' . $reply->image) : null,
                    'sender' => 'You',
                    'time' => $reply->created_at->format('g:i A'),
                ]
            ]);
        }

        return back()->with('success', 'Reply sent.');
    }

    public function close(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $ticket->update([
            'status' => 'closed',
            'has_admin_read' => false
        ]);

        return back()->with('success', 'Ticket closed successfully.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:255',
            'message' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = date('Y-m-d_(H-i)') . '_' . $index . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('tickets', $filename, 'public');
                $imagePaths[] = $path;
            }
        }

        Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
            'images' => $imagePaths
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Ticket created successfully');
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        $ticket->update([
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Ticket updated successfully');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Deletion of images is now handled by the Ticket model's deleting event
        $ticket->delete();

        return redirect()->route('user.dashboard')->with('success', 'Ticket deleted successfully');
    }

    /** Get ticket chat data for AJAX popup. */
    public function getChatData($id)
    {
        $ticket = Ticket::with(['user', 'replies.admin'])->findOrFail($id);

        if ($ticket->user_id !== Auth::id() && Auth::user()->role != 1) {
            abort(403, 'Unauthorized');
        }

        $unreadCount = $ticket->replies->whereNotNull('admin_id')->where('is_read', 0)->count();

        // Mark as read for user
        if (!$ticket->has_user_read) {
            $ticket->update(['has_user_read' => true]);
        }
        $ticket->replies()->whereNotNull('admin_id')->where('is_read', false)->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'ticket' => [
                'id' => $ticket->id,
                'subject' => $ticket->subject,
                'status' => $ticket->status,
                'user_name' => $ticket->user->name ?? 'User',
            ],
            'unread_count' => $unreadCount,
            'replies' => $ticket->replies->map(function ($reply) {
                static $dividerInserted = false;
                $isFirstUnread = false;

                if (!$dividerInserted && $reply->isFromAdmin() && !$reply->is_read) {
                    $isFirstUnread = true;
                    $dividerInserted = true;
                }

                return [
                    'body' => $reply->body,
                    'image' => $reply->image ? asset('storage/' . $reply->image) : null,
                    'is_admin' => $reply->isFromAdmin(),
                    'sender' => $reply->isFromAdmin() ? ($reply->admin->name ?? 'Support') : 'You',
                    'time' => $reply->created_at->format('g:i A'),
                    'is_first_unread' => $isFirstUnread,
                ];
            })
        ]);
    }

}
