@extends('layouts.app')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold-primary: #d4af53;
            --gold-light: #c9972a;
            --gold-dark: #b8860b;
            --bg-light: #f8f9fa;
            --card-bg: rgba(255, 255, 255, 0.9);
            --border-soft: rgba(0, 0, 0, 0.05);
            --text-dark: #1a1a1a;
            --text-muted: #6c757d;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            font-family: 'Outfit', sans-serif;
        }

        .premium-container {
            padding: 2rem 1rem;
        }

        .premium-card {
            background: var(--card-bg);
            border: 1px solid var(--border-soft);
            border-radius: 20px;
            padding: 1.8rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        }

        .page-title {
            font-weight: 700;
            font-size: 2rem;
            background: linear-gradient(135deg, var(--text-dark) 0%, var(--gold-primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.3rem;
        }

        .filter-section {
            background: #fff;
            border-radius: 16px;
            padding: 1.2rem;
            border: 1px solid var(--border-soft);
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.01);
        }

        .form-select-premium {
            background: #fdfdfd;
            border: 1px solid rgba(212, 175, 83, 0.25);
            color: var(--text-dark);
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-select-premium:focus {
            border-color: var(--gold-primary);
            box-shadow: 0 0 10px rgba(212, 175, 83, 0.1);
        }

        .top-performer-card {
            background: #fff;
            border: 1px solid var(--border-soft);
            border-left: 4px solid transparent;
            border-radius: 16px;
            padding: 1.1rem 1.4rem;
            display: flex;
            align-items: center;
            margin-bottom: 0.9rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .top-performer-card.leader {
            border-left-color: var(--gold-primary);
            background: linear-gradient(to right, rgba(212, 175, 83, 0.02), #fff);
        }

        .rank-indicator {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--bg-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-muted);
            margin-right: 1.2rem;
            border: 1px solid var(--border-soft);
        }

        .leader .rank-indicator {
            background: var(--gold-primary);
            color: #fff;
            border-color: var(--gold-primary);
            box-shadow: 0 4px 10px rgba(212, 175, 83, 0.3);
        }

        .performer-info h4 {
            margin: 0;
            font-weight: 600;
            font-size: 1rem;
            color: var(--text-dark);
            letter-spacing: -0.01em;
        }

        .ticket-count-badge {
            background: var(--bg-light);
            color: var(--text-dark);
            font-weight: 700;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            font-size: 0.8rem;
            margin-left: auto;
            border: 1px solid var(--border-soft);
            transition: all 0.3s;
        }

        .leader .ticket-count-badge {
            background: var(--gold-primary);
            color: #fff;
            border-color: var(--gold-primary);
        }

        .chart-container {
            position: relative;
            height: 320px;
        }

        .btn-gold-action {
            background: var(--gold-primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1.4rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-gold-action:hover {
            background: var(--gold-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 83, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            color: var(--text-muted);
        }
    </style>
@endpush

@section('navbar-buttons')
    <a href="{{ route('admin.dashboard') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg> Dashboard
    </a>
    <a href="{{ route('admin.knowledge-base.index') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
        </svg>
        Manage KB
    </a>
    <a href="{{ route('admin.users.index') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path
                d="M12 4.354a4 4 0 1 1 0 5.292M15 21H3v-1a6 6 0 0 1 12 0v1zm0 0h6v-1a6 6 0 0 0-9-5.197m13.5-9a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
        </svg>
        Users
    </a>
    <a href="{{ route('admin.ranking.index') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M12 20V10M18 20V4M6 20v-4" />
        </svg>
        Ranking
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
    <div class="premium-container container">
        <div class="row align-items-end mb-5">
            <div class="col-lg-7 text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="page-title">Performance Elite</h1>
                <p class="text-muted lead mb-lg-0">Recognizing excellence in service and ticket resolution.</p>
            </div>
            <div class="col-lg-5">
                <form action="{{ route('admin.ranking.index') }}" method="GET"
                    class="filter-section d-flex flex-wrap flex-lg-nowrap gap-2 gap-lg-3 align-items-end mb-0">
                    <div class="flex-grow-1 flex-lg-grow-0" style="min-width: 60px;">
                        <label class="form-label small text-uppercase fw-bold text-muted mb-2 text-start d-block"> Day</label>
                        <select name="day" class="form-select form-select-premium shadow-none">
                            <option value="all" {{ $day == 'all' || !$day ? 'selected' : '' }}>All</option>
                            @foreach(range(1, 31) as $d)
                                <option value="{{ $d }}" {{ $day == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-grow-1 flex-lg-grow-0" style="min-width: 60px;">
                        <label class="form-label small text-uppercase fw-bold text-muted mb-2 text-start d-block"> Month</label>
                        <select name="month" class="form-select form-select-premium shadow-none">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ Carbon\Carbon::create()->month($m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-grow-1 flex-lg-grow-0" style="min-width: 80px;">
                        <label class="form-label small text-uppercase fw-bold text-muted mb-2 text-start d-block"> Year</label>
                        <select name="year" class="form-select form-select-premium shadow-none">
                            @foreach(range(now()->year - 2, now()->year) as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gold-action shadow-none w-100 w-lg-auto mt-2 mt-lg-0">
                        Show
                    </button>
                </form>
            </div>
        </div>

        @if($rankings->isEmpty())
            <div class="premium-card empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                    stroke-linecap="round" stroke-linejoin="round" class="mb-4">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <h3>No data available</h3>
                <p>We couldn't find any closed tickets for the selected period.</p>
            </div>
        @else
            <div class="row">
                <div class="col-xl-5 mb-4">
                    <div class="premium-card h-100">
                        <h4 class="mb-4 fw-bold">Executive Ranking</h4>
                        <div class="ranking-list">
                            @php
                                $maxTickets = $rankings->max('tickets_count');
                                $currentRank = 1;
                                $prevTickets = -1;
                            @endphp
                            @foreach($rankings as $index => $ranking)
                                @php
                                    if ($prevTickets != -1 && $ranking->tickets_count < $prevTickets) {
                                        $currentRank = $index + 1;
                                    }
                                    $prevTickets = $ranking->tickets_count;
                                @endphp
                                <div class="top-performer-card {{ $ranking->tickets_count == $maxTickets ? 'leader' : '' }}"
                                    style="animation: slideIn {{ 0.3 + ($index * 0.1) }}s ease forwards;">
                                    <div class="rank-indicator">
                                        {{ $currentRank }}
                                    </div>
                                    <div class="performer-info">
                                        <h4 class="d-flex align-items-center">
                                            {{ $ranking->closer->name ?? 'User' }}
                                        </h4>
                                    </div>
                                    <div class="ticket-count-badge">
                                        {{ $ranking->tickets_count }} <span
                                            class="small font-weight-normal opacity-75">Solved</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 mb-4">
                    <div class="premium-card h-100">
                        <h4 class="mb-2 fw-bold">Performance Analytics</h4>
                        <p class="text-muted small mb-4">Visual distribution of monthly resolutions.</p>
                        <div class="chart-container">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-15px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(!$rankings->isEmpty())
                const ctx = document.getElementById('performanceChart').getContext('2d');

                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(212, 175, 83, 0.4)');
                gradient.addColorStop(1, 'rgba(212, 175, 83, 0.05)');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($rankings->map(fn($r) => $r->closer->name ?? 'Unknown')),
                        datasets: [{
                            label: 'Tickets Resolved',
                            data: @json($rankings->pluck('tickets_count')),
                            backgroundColor: gradient,
                            borderColor: 'rgba(212, 175, 83, 0.8)',
                            borderWidth: 2,
                            borderRadius: 15,
                            borderSkipped: false,
                            barPercentage: 0.7,
                            categoryPercentage: 0.7,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#fff',
                                titleColor: '#000',
                                bodyColor: '#666',
                                borderColor: 'rgba(212, 175, 83, 0.2)',
                                borderWidth: 1,
                                padding: 12,
                                cornerRadius: 10,
                                displayColors: false
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: '#666', font: { weight: '600' } }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.03)' },
                                ticks: { color: '#999', stepSize: 1 }
                            }
                        }
                    }
                });
            @endif
        });
    </script>
@endpush