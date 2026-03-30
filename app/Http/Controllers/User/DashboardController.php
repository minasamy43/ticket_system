<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $defaultDate = now()->format('Y-m-d');
        $date = request()->filled('date') ? request('date') : $defaultDate;

        $openTickets = Ticket::where('user_id',$userId)->whereDate('created_at', $date)->where('status','open')->count();

        $inprogressTickets = Ticket::where('user_id',$userId)->whereDate('created_at', $date)->where('status','in progress')->count();

        $closedTickets = Ticket::where('user_id',$userId)->whereDate('created_at', $date)->where('status','closed')->count();

        $totalTickets = Ticket::where('user_id',$userId)->whereDate('created_at', $date)->count();

        $tickets = Ticket::where('user_id',$userId)
                        ->whereDate('created_at', $date)
                        ->withCount(['replies as unread_replies_count' => function($query) {
                            $query->whereNotNull('admin_id')->where('is_read', 0);
                        }])
                        ->latest()->paginate(10);

        return view('user.dashboard',compact(
            'openTickets',
            'inprogressTickets',
            'closedTickets',
            'totalTickets',
            'tickets',
            'date'
        ));
    }
}
