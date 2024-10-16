<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index() //functie die je moet refeneren
    {
        return view('home');
    }

}
