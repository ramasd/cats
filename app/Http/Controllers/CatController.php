<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatController extends Controller
{
    public function index($n)
    {
        return $n;
    }
}
