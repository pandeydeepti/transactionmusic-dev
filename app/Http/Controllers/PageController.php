<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
class PageController extends Controller
{
    public function faq()
    {
        $faqs = Page::where('type', 'faq')->orderBy('order', 'ASC')->get();

        return view('pages.faq', ['faqs' => $faqs]);
    }
    public function index($slug)
    {
        $page = Page::where('slug', $slug)->first();

        return view('pages.index', ['page' => $page]);
    }
}
