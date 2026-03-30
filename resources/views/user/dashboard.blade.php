@extends('layouts.app')

@section('title', 'User Dashboard')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600&display=swap" rel="stylesheet">
@section('navbar-buttons')
    <a href="{{ route('tickets.create') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M12 5v14M5 12h14" />
        </svg>
        Create Ticket
    </a>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="btn-logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            Logout
        </button>
    </form>
@endsection

@section('content')

    <style>
        /* Royal Minimalist Cards */
        .royal-card {
            background: #ffffff;
            border-radius: 18px;
            position: relative;
            padding: 1.6rem 1.75rem 1.4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 130px;
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04), 0 1px 3px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .royal-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.08);
            border-color: rgba(var(--accent-rgb, 212, 175, 83), 0.25);
        }

        /* Left accent bar */
        .royal-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 4px;
            background: var(--accent-color, #d4af53);
            border-radius: 4px 0 0 4px;
        }

        /* Top edge gradient shimmer */
        .royal-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 4px;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-color, #d4af53) 0%, transparent 100%);
            opacity: 0.18;
            border-radius: 0 18px 0 0;
        }

        .royal-card-watermark {
            position: absolute;
            right: -8px;
            bottom: -8px;
            color: var(--accent-color, #d4af53);
            opacity: 0.19;
            transform: rotate(-15deg);
            z-index: 0;
        }

        .royal-card-content {
            position: relative;
            z-index: 1;
        }

        .royal-card-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 0.55rem;
        }

        .royal-card-value {
            font-family: 'Inter', sans-serif;
            font-size: 2rem;
            font-weight: 500;
            color: #111;
            line-height: 1;
            letter-spacing: -1px;
        }

        .royal-card-sub {
            font-size: 0.72rem;
            color: #bbb;
            margin-top: 0.45rem;
            font-family: 'DM Sans', sans-serif;
        }

        .royal-card-icon-min {
            position: absolute;
            top: 1.4rem;
            right: 1.4rem;
            width: 52px;
            height: 52px;
            background: var(--icon-bg, rgba(212, 175, 83, 0.08));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color, #d4af53);
            font-size: 1.45rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .royal-card:hover .royal-card-icon-min {
            transform: scale(1.1) rotate(-5deg);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
        }

        /* Standard Table Overrides to match Admin View */
        .table-bordered {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e8eaed !important;
            box-shadow: 0 1px 15px rgba(0, 0, 0, 0.02);
        }

        .table-bordered thead th {
            background: #f8f9fa;
            color: #555;
            font-weight: 600;
            text-transform: none;
            letter-spacing: normal;
            font-size: 0.88rem;
            padding: 12px 15px;
            border-bottom: 2px solid #e8eaed !important;
        }

        .table-bordered tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            font-size: 0.92rem;
            border-color: #e8eaed !important;
        }

        .table-bordered tbody tr:hover td {
            background: rgba(212, 175, 83, 0.08) !important;
        }

        .action-btn-premium {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            background: #fff;
            border: 1px solid #e8eaed;
            border-radius: 12px;
            color: #666;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            vertical-align: middle;
            position: relative;
            text-decoration: none;
        }

        .action-btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            color: #3b6fd4;
            border-color: rgba(59, 111, 212, 0.2);
        }

        .action-btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
            color: #dc3545;
            border-color: rgba(220, 53, 69, 0.25);
            background: rgba(220, 53, 69, 0.02);
        }
    </style>

    <div class="container mt-4">

        <div class="mb-5">
            <h2 style="font-family: 'Playfair Display', serif; font-weight: 600; color: #0a0a0a; margin-bottom: 4px;">
                👋 Welcome, <span style="color: #d4af53;">{{ Auth::user()->name }}</span>
            </h2>
            <p style="color: #666; margin-top: 15px; font-size: 0.95rem; display: flex; align-items: center; gap: 12px;">
                <span
                    style="font-family: 'DM Sans', sans-serif; font-size: 0.68rem; color: #3b6fd4; font-weight: 800; text-transform: uppercase; letter-spacing: 1.2px; background: rgba(59, 111, 212, 0.07); padding: 4px 12px; border-radius: 50px; border: 1px solid rgba(59, 111, 212, 0.12); box-shadow: 0 2px 5px rgba(59, 111, 212, 0.05); white-space: nowrap;">
                    <span style="margin-right: 4px;">👤</span> User
                </span>
                Manage your support tickets and track their status below.
            </p>
        </div>

        <div class="row g-4">

            <!-- Open Tickets -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="royal-card h-100" style="--accent-color: #dc3545; --icon-bg: rgba(220, 53, 69, 0.08);">
                    <div class="royal-card-watermark">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M2 9V5.2a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2V9a2 2 0 0 0 0 6v3.8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V15a2 2 0 0 0 0-6z" />
                            <path d="M14 3v2" />
                            <path d="M14 8v2" />
                            <path d="M14 13v2" />
                            <path d="M14 18v2" />
                        </svg>
                    </div>
                    <div class="royal-card-content">
                        <div class="royal-card-title">Open Tickets</div>
                        <div class="royal-card-value">{{ $openTickets }}</div>
                        <div class="royal-card-sub">Awaiting response</div>
                    </div>
                </div>
            </div>

            <!-- In Progress -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="royal-card" style="--accent-color: #d4af53; --icon-bg: rgba(212, 175, 83, 0.08);">
                    <div class="royal-card-watermark">
                        <span style="font-size: 80px;">👍🏻</span>
                    </div>
                    <div class="royal-card-content">
                        <div class="royal-card-title">In Progress</div>
                        <div class="royal-card-value">{{ $inprogressTickets }}</div>
                        <div class="royal-card-sub">Being handled</div>
                    </div>
                </div>
            </div>

            <!-- Closed Tickets -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="royal-card h-100" style="--accent-color: #198754; --icon-bg: rgba(25, 135, 84, 0.08);">
                    <div class="royal-card-watermark">
                        <span style="font-size: 80px;">✅️</span>
                    </div>
                    <div class="royal-card-content">
                        <div class="royal-card-title">Closed Tickets</div>
                        <div class="royal-card-value">{{ $closedTickets }}</div>
                        <div class="royal-card-sub">Resolved & closed</div>
                    </div>
                </div>
            </div>

                        <!-- Total Tickets -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="royal-card h-100" style="--accent-color: #3b6fd4; --icon-bg: rgba(59, 111, 212, 0.08);">
                    <div class="royal-card-watermark">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            <path d="M12 11h4"></path>
                            <path d="M12 16h4"></path>
                            <path d="M8 11h.01"></path>
                            <path d="M8 16h.01"></path>
                        </svg>
                    </div>
                    <div class="royal-card-content">
                        <div class="royal-card-title">Total Tickets</div>
                        <div class="royal-card-value">{{ $totalTickets }}</div>
                        <div class="royal-card-sub">All time requests</div>
                    </div>
                </div>
            </div>
            
        </div>

        

        <div class="card mt-4 shadow-sm border-0" style="border-radius: 16px; overflow: hidden;">

            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom-0">
<span class="m-0" style="font-weight: 550; color: #111; font-family: 'Inter', sans-serif; font-size: 1.05rem;">
  Recent Tickets
</span>                <form method="GET" class="d-flex align-items-center m-0">
                    <label for="date" class="form-label me-2 mb-0 text-nowrap" style="font-size: 0.85rem; color: #666;">Filter Date:</label>
                    <input type="date" class="form-control form-control-sm" id="date" name="date"
                        value="{{ $date }}" onchange="this.form.submit()" style="border-radius: 8px; border-color: #eee;">
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="overflow: visible;">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Closed By</th>
                                <th>Date</th>
                                <th class="text-start">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr data-ticket-id="{{ $ticket->id }}" style="cursor: pointer;">
                                    <td style="font-weight: 500;">{{ $ticket->subject }}</td>
                                    <td>
                                        <span class="badge"
                                            style="padding: 0.5rem 0.8rem; border-radius: 10px; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;
                                            @if ($ticket->status == 'open') background: rgba(220, 53, 69, 0.1); color: #dc3545;
                                            @elseif($ticket->status == 'in progress') background: rgba(212, 175, 83, 0.15); color: #b8860b;
                                            @else background: rgba(25, 135, 84, 0.1); color: #198754; @endif">
                                            {{ ucfirst($ticket->status) }}
                                            @if ($ticket->status == 'open')
                                                🎟️
                                            @elseif($ticket->status == 'in progress')
                                                👍🏻
                                            @else
                                                ✅️
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $ticket->closer->name ?? '---' }}</td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:8px;">
                                            <span style="color:#d4af53; flex-shrink:0;">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <polyline points="12 6 12 12 16 14" />
                                                </svg>
                                            </span>
                                            <div>
                                                <div
                                                    style="font-weight:600; color:#333; font-size:0.88rem; line-height:1.2;">
                                                    {{ $ticket->created_at->format('g:i A') }}
                                                </div>
                                                <div style="font-size:0.72rem; color:#aaa; margin-top:2px;">
                                                    {{ $ticket->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-start">
                                        <div class="d-flex align-items-center gap-1">
                                            @php
                                                $msgCount = $ticket->unread_replies_count ?? 0;
                                            @endphp
                                            <a href="javascript:void(0)" onclick="openAdminChat({{ $ticket->id }})"
                                                class="action-btn-premium" title="Chat">
                                                <svg viewBox="0 0 256 256" width="24" height="24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <defs>
                                                        <linearGradient id="messenger-grad" x1="0" y1="1" x2="1" y2="0">
                                                            <stop offset="0%" stop-color="#00C6FF" />
                                                            <stop offset="50%" stop-color="#0078FF" />
                                                            <stop offset="100%" stop-color="#A033FF" />
                                                        </linearGradient>
                                                    </defs>
                                                    <path fill="url(#messenger-grad)"
                                                        d="M128,24C68.9,24,21,68.6,21,123.5c0,31.2,15.7,58.5,40.1,76.5c1.4,1,2.5,2.6,2.8,4.3l3.8,27.3c0.4,3,3.7,4.8,6.4,3.3l29.1-14.9c1-0.5,2.2-0.6,3.2-0.3c7.2,1.8,14.8,2.7,22.7,2.7c59.1,0,107-44.6,107-99.5S187.1,24,128,24z M138.8,148v-0.1l-25.5-27c-4-4.2-10.6-4.5-15.1-0.5l-31.5,28.5c-3,2.7-7.2-0.8-5.2-4.1l29.4-48c3.2-5.3,10.6-6.6,15.5-2.8l25.3,19.3c3.8,2.9,9.3,3.3,13.5-0.1l32-26.1c3-2.5,7,1,5.2,4.3L153,141.5C149.8,146.9,142.5,148.6,138.8,148z" />
                                                </svg>

                                                @if($msgCount > 0)
                                                    <span id="unread-count-{{ $ticket->id }}"
                                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light shadow-sm"
                                                        style="font-size: 0.66rem; padding: 0.24em 0.45em; line-height: 1;">
                                                        {{ $msgCount > 99 ? '99+' : $msgCount }}
                                                    </span>
                                                @endif
                                            </a>

                                            {{-- Direct Delete Button --}}
                                            <form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}"
                                                class="m-0" onsubmit="return confirm('Delete this ticket?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-btn-premium action-btn-danger" title="Delete Ticket">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted mb-2">No tickets found</div>
                                        <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-primary">Create Your First Ticket</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination inside the card-body --}}
                @if ($tickets->hasPages())
                    <div class="px-4 pb-4">
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <small class="text-muted">
                                Showing {{ $tickets->firstItem() }}–{{ $tickets->lastItem() }} of {{ $tickets->total() }} tickets
                            </small>
                            {{ $tickets->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('admin.partials._chat')

    <script>
        // Make table rows clickable (safe mode - matches Admin)
        document.querySelectorAll('table tbody tr').forEach(row => {
            row.addEventListener('click', function (e) {
                // Don't navigate if clicking on interactive elements
                const isInteractive = e.target.closest('a') || 
                                    e.target.closest('button') || 
                                    e.target.closest('input') || 
                                    e.target.closest('select');

                if (isInteractive) return;

                const ticketId = this.getAttribute('data-ticket-id');
                if (ticketId) {
                    window.location.href = `/user/tickets/${ticketId}`;
                }
            });

            // Add hover effect
            row.addEventListener('mouseover', function () {
                this.style.backgroundColor = 'rgba(212, 175, 83, 0.08)';
            });
            row.addEventListener('mouseout', function () {
                this.style.backgroundColor = '';
            });
        });
    </script>

@endsection