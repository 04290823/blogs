<?php

namespace App\Http\Controllers\Proscenium;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BlogController extends Controller
{
    public function home(){
        return view('proscenium/home');
    }
}