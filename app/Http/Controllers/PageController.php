<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PointController;
use App\Models\Point;

class PageController extends Controller
{
    public function index() {
        if (Auth::check()) {
            $points = Point::where('user_id',Auth::id())
                            ->select('id','name','latitude','longitude')
                            ->orderBy('created_at','desc')
                            ->get();

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
