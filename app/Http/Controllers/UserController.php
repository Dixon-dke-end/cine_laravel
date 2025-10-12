<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class UserController extends Controller
{    
    public function index()
    {
        $var_movies=Movie::all();
        return view('user.index',['movies'=>$var_movies]);             
    }
}
