<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KbCategory;
use App\Models\KbFaq;

class KnowledgeBaseController extends Controller
{
    /**
     * Display a listing of knowledge base resources.
     */
    public function index()
    {
        $categories = KbCategory::with('articles')->get();
        $faqs = KbFaq::all();

        return view('user.knowledge-base', compact('categories', 'faqs'));
    }

    /**
     * Display a specific category and its articles.
     */
    public function showCategory($slug)
    {
        $category = KbCategory::where('slug', $slug)->with('articles')->firstOrFail();
        return view('knowledge-base.category', compact('category'));
    }

    /**
     * Display a specific article.
     */
    public function showArticle($slug)
    {
        $article = \App\Models\KbArticle::where('slug', $slug)->with('category')->firstOrFail();
        return view('knowledge-base.article', compact('article'));
    }
}
