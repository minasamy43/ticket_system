@extends('layouts.app')


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
            Dashboard
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
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap');

        .kb-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        /* Hero Section */
        .kb-hero {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
        }

        .kb-hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 60%, #b8860b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .kb-hero p {
            font-size: 1.15rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }

        /* Premium Search Bar */
        .search-wrap {
            max-width: 650px;
            margin: 0 auto;
            position: relative;
        }

        .search-input-prem {
            width: 100%;
            padding: 1.2rem 1.5rem 1.2rem 3.5rem;
            border-radius: 18px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: #fff;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.05);
            font-size: 1.05rem;
            color: #1a1a1a;
            outline: none;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .search-input-prem:focus {
            border-color: #d4af53;
            box-shadow: 0 20px 50px rgba(212, 175, 83, 0.12);
            transform: translateY(-2px);
        }

        .search-icon-fixed {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: #d4af53;
            pointer-events: none;
        }

        /* Category Grid */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .category-card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            text-decoration: none;
            color: inherit;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
            border-color: rgba(212, 175, 83, 0.2);
        }

        .cat-icon-wrap {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            background: rgba(212, 175, 83, 0.08);
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            transition: all 0.3s ease;
        }

        .category-card:hover .cat-icon-wrap {
            background: #d4af53;
            color: #fff;
            transform: rotate(-10deg) scale(1.1);
        }

        .category-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 0.75rem;
        }

        .category-card p {
            font-size: 0.92rem;
            color: #777;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .article-count {
            font-size: 0.8rem;
            font-weight: 700;
            color: #d4af53;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* FAQ Section */
        .faq-section {
            margin-top: 6rem;
        }

        .faq-section h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 60%, #b8860b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .faq-item {
            background: #fff;
            border-radius: 16px;
            margin-bottom: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: rgba(212, 175, 83, 0.15);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        }

        .faq-question {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 600;
            color: #222;
        }

        .faq-answer {
            padding: 0 2rem;
            max-height: 0;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .faq-item.active .faq-answer {
            padding: 0 2rem 2rem;
            max-height: 200px;
        }

        .faq-toggle-icon {
            color: #d4af53;
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-toggle-icon {
            transform: rotate(180deg);
        }

        /* Responsive Mobile Styles */
        @media (max-width: 768px) {
            .kb-hero h1 {
                font-size: 2.5rem;
            }

            .category-grid {
                grid-template-columns: 1fr;
            }

            .kb-container {
                padding-top: 1.5rem;
            }
        }
    </style>

    <div class="kb-container">
        {{-- Hero --}}
        <header class="kb-hero">
            <h1>Knowledge Base</h1>
            <p>Search our comprehensive library of guides and answers or browse by category to find exactly what you need.
            </p>

            <div class="search-wrap">
                <span class="search-icon-fixed">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input type="text" class="search-input-prem" id="kbSearchInput"
                    placeholder="Search for articles, topics or keywords..." onkeyup="filterKB()">
            </div>
        </header>

        {{-- Categories --}}
        <div class="category-grid" id="kbGrid">
            @foreach($categories as $cat)
                <a href="{{ route('knowledge.category', $cat->slug) }}" class="category-card"
                    data-title="{{ strtolower($cat->title) }}" data-desc="{{ strtolower($cat->description) }}">
                    <div class="cat-icon-wrap">{{ $cat->icon }}</div>
                    <h3>{{ $cat->title }}</h3>
                    <p>{{ $cat->description }}</p>
                    <div class="article-count">
                        <span>{{ count($cat->articles) }} Articles</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- FAQ --}}
        <section class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="max-width: 750px; margin: 0 auto;">
                @foreach($faqs as $index => $faq)
                    <div class="faq-item" onclick="toggleFaq(this)">
                        <div class="faq-question">
                            {{ $faq->question }}
                            <span class="faq-toggle-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div class="faq-answer">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <script>
        function filterKB() {
            const input = document.getElementById('kbSearchInput').value.toLowerCase();

            // Filter Categories
            const cards = document.querySelectorAll('.category-card');
            cards.forEach(card => {
                const title = card.getAttribute('data-title');
                const desc = card.getAttribute('data-desc');

                if (title.includes(input) || desc.includes(input)) {
                    card.style.display = 'flex';
                    card.style.opacity = '1';
                } else {
                    card.style.display = 'none';
                    card.style.opacity = '0';
                }
            });

            // Filter FAQs
            const faqs = document.querySelectorAll('.faq-item');
            faqs.forEach(faq => {
                const questionElement = faq.querySelector('.faq-question');
                const answerElement = faq.querySelector('.faq-answer');

                const question = questionElement ? questionElement.innerText.toLowerCase() : '';
                const answer = answerElement ? answerElement.innerText.toLowerCase() : '';

                if (question.includes(input) || answer.includes(input)) {
                    faq.style.display = '';
                } else {
                    faq.style.display = 'none';
                }
            });
        }

        function toggleFaq(el) {
            const isActive = el.classList.contains('active');

            // Close all others
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
            });

            if (!isActive) {
                el.classList.add('active');
            }
        }
    </script>
@endsection