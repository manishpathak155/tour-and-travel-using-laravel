<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * Render static pages.
 */
class PageController extends Controller
{
    /**
     * Display the about page.
     *
     * @return View
     */
    public function about(): View
    {
        return view('pages.about');
    }

    /**
     * Display the contact page.
     *
     * @return View
     */
    public function contact(): View
    {
        return view('pages.contact');
    }
}
