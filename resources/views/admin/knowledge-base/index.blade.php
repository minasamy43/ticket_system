@extends('layouts.app')

@section('title', 'Manage Knowledge Base')

@section('navbar-buttons')
    <a href="{{ route('admin.dashboard') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        Dashboard n
    </a>
    <a href="{{ route('admin.knowledge-base.index') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
        </svg>
        Manage KB
    </a>
    <a href="{{ route('admin.users.index') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 4.354a4 4 0 1 1 0 5.292M15 21H3v-1a6 6 0 0 1 12 0v1zm0 0h6v-1a6 6 0 0 0-9-5.197m13.5-9a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/></svg>
        Users
    </a>
    <a href="{{ route('admin.ranking.index') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>
        Ranking
    </a>
     <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="btn-logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Logout
        </button>
    </form>
@endsection

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap');
    
    .manage-container {
        font-family: 'DM Sans', sans-serif;
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-title {
        font-family: 'Outfit', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 60%, #b8860b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
    }

    .item-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }

    .item-card:hover {
        border-color: rgba(212, 175, 83, 0.2);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .btn-premium-action {
        background: rgba(212, 175, 83, 0.1);
        color: #b8860b;
        border: none;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-premium-action:hover {
        background: #d4af53;
        color: #fff;
    }

    .btn-premium-danger {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: none;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-premium-danger:hover {
        background: #dc3545;
        color: #fff;
    }

    .sub-item-list {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px dashed rgba(0,0,0,0.1);
    }
    
    .btn-nav-match {
        background-color: rgb(55, 55, 55);
        border-color: rgb(55, 55, 55);
        color: white;
        transition: all 0.2s ease;
    }
    
    .btn-nav-match:hover {
        background-color: rgb(45, 45, 45);
        border-color: rgb(45, 45, 45);
        color: white;
    }

    .btn-nav-match:hover {
        background-color: rgb(45, 45, 45);
        border-color: rgb(45, 45, 45);
        color: white;
    }
</style>

<div class="container mt-4 manage-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; font-weight: 500;">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Categories Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h2 class="section-title" style="margin-bottom: 0;">Knowledge Categories</h2>
        <button class="btn btn-nav-match" style="border-radius: 12px; font-weight: 600;" data-bs-toggle="modal" data-bs-target="#createCategoryModal">+ New Category</button>
    </div>

    <div class="row">
        @foreach($categories as $category)
            <div class="col-12 mb-4">
                <div class="item-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 style="font-weight: 700; color: #111; margin-bottom: 0.3rem;">
                                <span style="font-size: 1.5rem; margin-right: 0.5rem;">{{ $category->icon }}</span> {{ $category->title }}
                            </h4>
                            <p style="color: #666; font-size: 0.95rem; margin-bottom: 0;">{{ $category->description }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn-premium-action" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">Edit</button>
                            <form action="{{ route('admin.knowledge-base.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category and all its articles?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-premium-danger">Delete</button>
                            </form>
                        </div>
                    </div>

                    <!-- Nested Articles -->
                    <div class="sub-item-list">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 style="font-weight: 700; margin: 0; color: #555;">Articles ({{ count($category->articles) }})</h6>
                            <button class="btn btn-sm btn-outline-secondary" style="border-radius: 8px; font-size: 0.75rem; font-weight: 600;" data-bs-toggle="modal" data-bs-target="#createArticleModal" onclick="document.getElementById('article-cat-id').value='{{ $category->id }}'">+ Add Article</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-borderless align-middle mb-0">
                                <tbody>
                                    @foreach($category->articles as $article)
                                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                        <td style="font-weight: 500; color: #333;" colspan="2">📄 {{ $article->title }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm text-primary p-0 mx-2" data-bs-toggle="modal" data-bs-target="#editArticleModal{{ $article->id }}">Edit</button>
                                            <form action="{{ route('admin.knowledge-base.articles.destroy', $article->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete article?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm text-danger p-0 pt-1">Del</button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                    <!-- Edit Article Modal -->
                                    <div class="modal fade" id="editArticleModal{{ $article->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="border-radius: 16px; border: none;">
                                                <div class="modal-header" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                                    <h5 class="modal-title" style="font-weight: 700;">Edit Article</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.knowledge-base.articles.update', $article->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label" style="font-weight: 600;">Category</label>
                                                            <select name="kb_category_id" class="form-select" required>
                                                                @foreach($categories as $c)
                                                                    <option value="{{ $c->id }}" {{ $article->kb_category_id == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" style="font-weight: 600;">Title</label>
                                                            <input type="text" name="title" class="form-control" value="{{ $article->title }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" style="font-weight: 600;">Content (HTML)</label>
                                                            <textarea name="content" class="form-control" rows="4">{{ $article->content }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="border-top: none;">
                                                        <button type="submit" class="btn btn-nav-match w-100" style="border-radius: 10px;">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if(count($category->articles) == 0)
                                        <tr><td colspan="3" class="text-muted" style="font-size: 0.85rem;">No articles in this category.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Edit Category Modal -->
                <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" style="border-radius: 16px; border: none;">
                            <div class="modal-header" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                <h5 class="modal-title" style="font-weight: 700;">Edit Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.knowledge-base.categories.update', $category->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600;">Title</label>
                                        <input type="text" name="title" class="form-control" value="{{ $category->title }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600;">Icon (Emoji/Text)</label>
                                        <input type="text" name="icon" class="form-control" value="{{ $category->icon }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600;">Description</label>
                                        <textarea name="description" class="form-control" rows="3" required>{{ $category->description }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-top: none;">
                                    <button type="submit" class="btn btn-nav-match w-100" style="border-radius: 10px;">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- FAQs Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <button class="btn btn-nav-match" style="border-radius: 12px; font-weight: 600;" data-bs-toggle="modal" data-bs-target="#createFaqModal">+ New FAQ</button>
    </div>

    <div class="row">
        @foreach($faqs as $faq)
        <div class="col-12 mb-3">
            <div class="item-card" style="padding: 1.25rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 style="font-weight: 700; color: #111; margin-bottom: 0.3rem;">Q: {{ $faq->question }}</h6>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 0;">A: {{ Str::limit($faq->answer, 120) }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn-premium-action" data-bs-toggle="modal" data-bs-target="#editFaqModal{{ $faq->id }}">Edit</button>
                        <form action="{{ route('admin.knowledge-base.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Delete this FAQ?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-premium-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit FAQ Modal -->
            <div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content" style="border-radius: 16px; border: none;">
                        <div class="modal-header" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                            <h5 class="modal-title" style="font-weight: 700;">Edit FAQ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.knowledge-base.faqs.update', $faq->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 600;">Question</label>
                                    <input type="text" name="question" class="form-control" value="{{ $faq->question }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 600;">Answer</label>
                                    <textarea name="answer" class="form-control" rows="4" required>{{ $faq->answer }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top: none;">
                                <button type="submit" class="btn btn-nav-match w-100" style="border-radius: 10px;">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Page Footer Preview Link -->
    <div class="text-center mt-5 pt-3 mb-2" style="border-top: 1px dashed rgba(0,0,0,0.05);">
        <a href="{{ route('knowledge.base') }}" target="_blank" style="font-size: 0.95rem; color: #888; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 6px; transition: color 0.2s;" onmouseover="this.style.color='#d4af53'" onmouseout="this.style.color='#888'">
            Preview User View
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" y1="14" x2="21" y2="3"></line>
            </svg>
        </a>
    </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                <h5 class="modal-title" style="font-weight: 700;">New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.knowledge-base.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Icon (Emoji/Text)</label>
                        <input type="text" name="icon" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="submit" class="btn btn-nav-match w-100" style="border-radius: 10px;">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Article Modal -->
<div class="modal fade" id="createArticleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                <h5 class="modal-title" style="font-weight: 700;">New Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.knowledge-base.articles.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Category</label>
                        <select name="kb_category_id" id="article-cat-id" class="form-select" required>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Content (HTML)</label>
                        <textarea name="content" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="submit" class="btn btn-nav-match w-100" style="border-radius: 10px;">Create Article</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create FAQ Modal -->
<div class="modal fade" id="createFaqModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                <h5 class="modal-title" style="font-weight: 700;">New FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.knowledge-base.faqs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Question</label>
                        <input type="text" name="question" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Answer</label>
                        <textarea name="answer" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="submit" class="btn btn-nav-match w-100" style="border-radius: 10px;">Create FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
