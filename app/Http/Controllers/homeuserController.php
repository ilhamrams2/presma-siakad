<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeuserController extends Controller
{

        public function home()
    {
        return view('home-user');
    }

}