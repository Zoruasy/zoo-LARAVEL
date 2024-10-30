<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index() //functie die je moet refeneren
    {
        return view('home');
    }

}
