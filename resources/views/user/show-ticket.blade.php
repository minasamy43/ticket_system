@extends('layouts.app')

@section('title', 'Ticket Details')

@section('navbar-buttons')
    <a href="{{ route('user.dashboard') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z" />
            <line x1="3" y1="7" x2="21" y2="7" />
        </svg>
        Dashboard
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
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap');

        .tk-wrap {
            max-width: 900px;
            margin: 1.5rem auto;
            padding: 0 1rem;
            font-family: 'DM Sans', sans-serif;
        }

        /* Premium Ticket Cards */
        .premium-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 18px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }

        /* Subtle gold top bar for main card */
        .premium-card.main-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #d4af53 0%, transparent 100%);
            opacity: 0.8;
        }

        .btn-back-premium {
            font-family: 'DM Sans', sans-serif;
            font-size: .85rem;
            font-weight: 600;
            color: #888;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: all 0.3s ease;
            padding: 0.5rem 1.2rem;
            border-radius: 10px;
            background: #fff;
            border: 1px solid #eee;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .btn-back-premium:hover {
            color: #d4af53;
            border-color: #d4af53;
            transform: translateX(-3px);
            box-shadow: 0 5px 15px rgba(212, 175, 83, 0.1);
        }

        /* Ticket Header */
        .ticket-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .ticket-id-badge {
            display: inline-block;
            background: rgba(212, 175, 83, 0.1);
            color: #b8860b;
            padding: 0.35rem 1rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        /* Meta Info Grid */
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(0, 0, 0, 0.04);
        }

        .meta-item-premium {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .meta-label-premium {
            font-size: 0.75rem;
            color: #a0a0a0;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 700;
        }

        .meta-value-premium {
            font-size: 1rem;
            color: #222;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .meta-icon {
            color: #d4af53;
            display: flex;
            align-items: center;
            background: rgba(212, 175, 83, 0.08);
            padding: 8px;
            border-radius: 8px;
        }

        /* Original Request Box */
        .orig-request-box {
            margin-top: 3rem;
            padding: 2.5rem;
            background: linear-gradient(145deg, #fdfbf7 0%, #ffffff 100%);
            border-radius: 16px;
            border: 1px solid rgba(212, 175, 83, 0.15);
            position: relative;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.01);
        }

        .orig-request-box::before {
            content: '"';
            position: absolute;
            top: -15px;
            left: 25px;
            font-family: 'Playfair Display', serif;
            font-size: 5rem;
            color: rgba(212, 175, 83, 0.15);
            line-height: 1;
        }

        .orig-request-label {
            font-size: 0.8rem;
            color: #d4af53;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .orig-request-text {
            font-size: 1.1rem;
            color: #444;
            line-height: 1.8;
            white-space: pre-wrap;
        }

        /* Status Pills */
        .status-pill-premium {
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid transparent;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-open-prem {
            background: rgba(220, 53, 69, 0.08);
            color: #dc3545;
            border-color: rgba(220, 53, 69, 0.2);
        }

        .status-progress-prem {
            background: rgba(212, 175, 83, 0.08);
            color: #b8860b;
            border-color: rgba(212, 175, 83, 0.2);
        }

        .status-closed-prem {
            background: rgba(25, 135, 84, 0.08);
            color: #198754;
            border-color: rgba(25, 135, 84, 0.2);
        }

        .pulse-dot-prem {
            width: 8px;
            height: 8px;
            background-color: #dc3545;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            animation: pulsePrem 1.5s infinite;
        }

        @keyframes pulsePrem {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(220, 53, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        /* Premium Image Styles */
        .tk-attachment-img {
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: zoom-in;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .tk-attachment-img:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(212, 175, 83, 0.4);
        }

        .btn-close-ticket-prem {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: #dc3545;
            background: #fff;
            border: 1px solid rgba(220, 53, 69, 0.2);
            padding: 0.5rem 1.2rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .btn-close-ticket-prem:hover {
            background: #dc3545;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.15);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .premium-card {
                padding: 1.5rem;
                border-radius: 12px;
            }

            .ticket-title {
                font-size: 1.6rem;
            }

            .orig-request-box {
                padding: 1.5rem;
                margin-top: 2rem;
            }

            .meta-grid {
                gap: 1.25rem;
                margin-top: 1.5rem;
                padding-top: 1.5rem;
            }

            .meta-value-premium {
                font-size: 0.9rem;
            }

            .orig-request-text {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .tk-wrap {
                margin: 1rem 0;
            }

            .tk-wrap .d-flex.justify-content-between.align-items-center {
                flex-direction: column;
                align-items: stretch !important;
                gap: 10px;
            }

            .btn-back-premium, .btn-close-ticket-prem {
                width: 100%;
                justify-content: center;
            }

            .main-card .d-flex.justify-content-between.align-items-start {
                flex-direction: column;
                gap: 15px;
            }

            .status-pill-premium {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="tk-wrap">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('user.dashboard') }}" class="btn-back-premium">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back to Dashboard
            </a>

            @if($ticket->status !== 'closed')
                <form method="POST" action="{{ route('tickets.close', $ticket->id) }}"
                    onsubmit="return confirm('Close this ticket?');" style="margin:0">
                    @csrf
                    <button type="submit" class="btn-close-ticket-prem">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            style="margin-right: 4px;">
                            <path d="M18 6L6 18M6 6l12 12"></path>
                        </svg>
                        Close Ticket
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert"
                style="background: #e8f5e9; border: 1px solid #c8e6c9; color: #2e7d32; border-radius: 12px;">
                <div class="d-flex align-items-center gap-2">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <strong>{{ session('success') }}</strong>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="opacity: 0.6;"></button>
            </div>
        @endif

        {{-- Main Section: Ticket Info --}}
        <div class="premium-card main-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="ticket-id-badge mb-3">TICKET #{{ $ticket->id }}</span>
                    <h1 class="ticket-title">{{ $ticket->subject }}</h1>
                </div>
                <div>
                    @if($ticket->status === 'open')
                        <span class="status-pill-premium status-open-prem" id="mainStatusPill">
                            <span class="pulse-dot-prem"></span> Open
                        </span>
                    @elseif($ticket->status === 'in progress')
                        <span class="status-pill-premium status-progress-prem" id="mainStatusPill">👍🏻 In Progress</span>
                    @else
                        <span class="status-pill-premium status-closed-prem" id="mainStatusPill">✅️ Closed</span>
                    @endif
                </div>
            </div>

            <div class="meta-grid">
                <div class="meta-item-premium">
                    <span class="meta-label-premium">Submitted On</span>
                    <span class="meta-value-premium">
                        <span class="meta-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg></span>
                        {{ $ticket->created_at->format('M d, Y') }} at {{ $ticket->created_at->format('g:i A') }}
                    </span>
                </div>

            </div>

            <div class="orig-request-box">
                <div class="orig-request-label">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    My Ticket Details
                </div>
                <div class="orig-request-text">{{ $ticket->message }}</div>
            </div>

            @if($ticket->images && count($ticket->images) > 0)
                <h5 class="mt-5 mb-4"
                    style="font-family:'Playfair Display',serif; font-size: 1.5rem; font-weight:700; color:#111; display:flex; align-items:center; gap:10px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4af53" stroke-width="2.5">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                        <polyline points="21 15 16 10 5 21" />
                    </svg>
                    Attached Files
                </h5>
                <div class="row g-4">
                    @foreach($ticket->images as $img)
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $img) }}" alt="Attachment" onclick="openGlobalLightbox(this.src)"
                                class="tk-attachment-img">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- Messenger Chat Component --}}
    @include('admin.partials._chat', ['ticket' => $ticket, 'isStatic' => false, 'withTrigger' => true])
@endsection