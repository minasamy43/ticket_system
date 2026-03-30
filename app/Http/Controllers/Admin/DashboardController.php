<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $defaultDate = now()->format('Y-m-d');
        $date = request()->filled('date') ? request('date') : $defaultDate;

        $totalTickets = Ticket::whereDate('created_at', $date)->count();
        $openTickets = Ticket::whereDate('created_at', $date)->where('status', 'open')->count();
        $closedTickets = Ticket::whereDate('created_at', $date)->where('status', 'closed')->count();
        $inProgress = Ticket::whereDate('created_at', $date)->where('status', 'in progress')->count();

        $query = Ticket::with(['user', 'closer'])
            ->withCount(['replies as unread_replies_count' => function ($query) {
                $query->where('is_read', 0)->whereNull('admin_id');
            }])
            ->whereDate('created_at', $date);

        if ($priority = request('priority')) {
            $query->where('priority', $priority);
        }

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        if ($userName = request('user_name')) {
            $query->whereHas('user', function($q) use ($userName) {
                $q->where('name', 'like', '%' . $userName . '%');
            });
        }

        if ($subject = request('subject')) {
            $query->where('subject', 'like', '%' . $subject . '%');
        }

        if ($closerName = request('closer_name')) {
            $query->whereHas('closer', function($q) use ($closerName) {
                $q->where('name', 'like', '%' . $closerName . '%');
            });
        }

        if ($inprogressName = request('inprogress_name')) {
            $query->whereHas('inprogressBy', function($q) use ($inprogressName) {
                $q->where('name', 'like', '%' . $inprogressName . '%');
            });
        }

        $tickets = $query->latest()->paginate(10);

        return view('admin.dashboard', compact(
            'totalTickets',
            'openTickets',
            'closedTickets',
            'inProgress',
            'tickets',
            'date'
        ));
    }
}
