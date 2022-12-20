<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index() {
        return view('home');
    }

    public function register() {
        return view('auth.register');
    }
    public function login() {
        return view('auth.login');
    }
}
