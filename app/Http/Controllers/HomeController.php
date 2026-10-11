<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        return view('homepage', ['name' => $request->name, 'id' => $request->id]);

    }
}
