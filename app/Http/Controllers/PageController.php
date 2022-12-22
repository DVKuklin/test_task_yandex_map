<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PointController;

class PageController extends Controller
{
    public function index() {
        if (Auth::check()) {
            $points = PointController::getPoints();
            return view('home',['points'=>$points]);
        }

        

        return view('home');
    }

    public function register() {
        if (Auth::user()) {
            return redirect()->route('page.home');
        }

        return view('auth.register');
    }
    public function login() {
        if (Auth::user()) {
            return redirect()->route('page.home');
        }
        
        return view('auth.login');
    }
}
