<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Handle blog and travel guide pages.
 */
class BlogController extends Controller
{
    /**
     * Display blog posts.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $posts = BlogPost::query()
            ->with('author')
            ->where('post_type', 'blog')
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    /**
     * Display travel guides.
     *
     * @param Request $request
     * @return View
     */
    public function guides(Request $request): View
    {
        $posts = BlogPost::query()
            ->with('author')
            ->where('post_type', 'travel_guide')
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('blog.guides', compact('posts'));
    }

    /**
     * Display a blog post.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        $post = BlogPost::query()
            ->with('author')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }
}
