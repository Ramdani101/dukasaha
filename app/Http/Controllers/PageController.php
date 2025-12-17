<?php

namespace App\Http\Controllers;

// <-- For Landing, About, Safety -->
class PageController extends Controller
{
    public function index()
    {
        return view('Pages.landing');
    }
    public function about()
    {
        return view('Pages.about');
    }
    public function safety()
    {
        return view('Pages.safety');
    }
    public function terms()
    {
        return view('Pages.terms');
    }
    public function privacy()
    {
        return view('Pages.privacy');
    }

}