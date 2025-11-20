<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // esta variável dirá ao layout que estamos na página inicial
        $isHomePage = true; 
        return view('welcome', compact('isHomePage'));
    }
}
