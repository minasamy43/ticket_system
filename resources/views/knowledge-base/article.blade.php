@extends('layouts.app')

@section('title', $article->title . ' - Knowledge Base')

@section('navbar-buttons')
    @if(Auth::user()->role == 1)
        <a href="{{ route('admin.dashboard') }}" class="btn-create">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            Admin Dashboard
        </a>
    @else
        <a href="{{ route('user.dashboard') }}" class="btn-create">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            My Dashboard
        </a>
    @endif
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

        .kb-container {
            max-width: 850px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #666;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #d4af53;
        }

        .article-content-wrapper {
            background: #fff;
            padding: 3rem 3.5rem;
            border-radius: 20px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.04);
        }

        .article-header {
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .cat-badge {
            display: inline-block;
            background: rgba(212, 175, 83, 0.1);
            color: #b8860b;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.35rem 0.8rem;
            border-radius: 50px;
            margin-bottom: 1.5rem;
        }

        .article-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.75rem;
            font-weight: 700;
            color: #111;
            margin: 0;
            line-height: 1.2;
        }

        .article-body {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #444;
        }

        .article-body p {
            margin-bottom: 1.5rem;
        }

        .article-body h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: #111;
            margin: 2.5rem 0 1rem;
        }

        .article-body h3 {
            font-weight: 600;
            font-size: 1.4rem;
            color: #222;
            margin: 2rem 0 1rem;
        }

        .article-body ul, .article-body ol {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }

        .article-body li {
            margin-bottom: 0.5rem;
        }

        .article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 1.5rem 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        @media (max-width: 768px) {
            .article-content-wrapper {
                padding: 2rem 1.5rem;
            }
            .article-header h1 {
                font-size: 2rem;
            }
        }
    </style>

    <div class="kb-container">
        <a href="{{ route('knowledge.category', $article->category->slug) }}" class="back-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to {{ $article->category->title }}
        </a>

        <div class="article-content-wrapper">
            <div class="article-header">
                <div class="cat-badge">{{ $article->category->icon }} {{ $article->category->title }}</div>
                <h1>{{ $article->title }}</h1>
            </div>

            <div class="article-body">
                @if($article->content)
                    {!! $article->content !!}
                @else
                    <p class="text-muted" style="font-style: italic;">This article doesn't have any content yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
