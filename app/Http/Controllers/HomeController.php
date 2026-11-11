<?php

namespace App\Http\Controllers;

use App\Support\DummyMusic;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', DummyMusic::home());
    }

    public function uiKit(): View
    {
        return view('ui-kit', DummyMusic::home());
    }
}
