<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function home(){
		return view('page');
	}

	public function admin(){
		return view('admin');
	}
}
