@extends('layouts.app')

@section('title', $category->title . ' - Knowledge Base')

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
            max-width: 900px;
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

        .cat-hero {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 3rem;
            background: #fff;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.04);
        }

        .cat-icon-wrap {
            font-size: 3rem;
            background: rgba(212, 175, 83, 0.08);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            flex-shrink: 0;
        }

        .cat-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 0.5rem;
        }

        .cat-hero p {
            font-size: 1.05rem;
            color: #666;
            margin: 0;
            line-height: 1.5;
        }

        .article-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .article-item {
            background: #fff;
            border-radius: 14px;
            padding: 1.5rem 1.75rem;
            text-decoration: none;
            color: inherit;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 2px 8px rgba(0,0,0,0.01);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .article-item:hover {
            transform: translateX(5px);
            border-color: rgba(212, 175, 83, 0.3);
            box-shadow: 0 8px 15px rgba(0,0,0,0.04);
        }

        .article-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: #111;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .article-wrapper.active .article-arrow {
            transform: rotate(180deg);
        }

        .article-content-container {
            padding: 0 1.75rem;
            max-height: 0;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fff;
            border-bottom-left-radius: 14px;
            border-bottom-right-radius: 14px;
            color: #444;
            line-height: 1.7;
            font-size: 1rem;
        }

        .article-wrapper.active .article-content-container {
            padding: 1rem 1.75rem 1.5rem;
            max-height: 2000px; /* large enough for long content */
            border: 1px solid rgba(212, 175, 83, 0.3);
            border-top: none;
            box-shadow: 0 8px 15px rgba(0,0,0,0.04);
        }

        .article-wrapper.active .article-item {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            border-color: rgba(212, 175, 83, 0.3);
            box-shadow: 0 2px 8px rgba(0,0,0,0.01);
            transform: none;
        }

        .article-content-container h2, .article-content-container h3 {
            font-family: 'Playfair Display', serif;
            color: #111;
            margin-top: 1.5rem;
        }
        
        .article-content-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1rem 0;
        }
    </style>

    <script>
        function toggleArticle(el) {
            const wrapper = el.closest('.article-wrapper');
            const isActive = wrapper.classList.contains('active');
            
            // Close all others
            document.querySelectorAll('.article-wrapper').forEach(item => {
                item.classList.remove('active');
            });
            
            if (!isActive) {
                wrapper.classList.add('active');
            }
        }
    </script>

    <div class="kb-container">
        <a href="{{ route('knowledge.base') }}" class="back-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Knowledge Base
        </a>

        <div class="cat-hero">
            <div class="cat-icon-wrap">{{ $category->icon }}</div>
            <div>
                <h1>{{ $category->title }}</h1>
                <p>{{ $category->description }}</p>
            </div>
        </div>

        <div class="article-list">
            @forelse($category->articles as $article)
                <div class="article-wrapper" style="margin-bottom: 1rem;">
                    <div class="article-item" onclick="toggleArticle(this)" style="cursor: pointer;">
                        <h3 class="article-title">
                            <span style="color: #d4af53; opacity: 0.8;">📄</span>
                            {{ $article->title }}
                        </h3>
                        <div class="article-arrow" style="transition: transform 0.3s ease;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="article-content-container">
                        @if($article->content)
                            {!! $article->content !!}
                        @else
                            <p class="text-muted" style="margin-bottom: 0; font-style: italic;">This article doesn't have any content yet.</p>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 4rem 1rem; color: #777;">
                    <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;">📭</div>
                    <p>No articles available in this category yet.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
