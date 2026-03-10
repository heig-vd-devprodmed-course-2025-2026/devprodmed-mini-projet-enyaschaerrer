<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;


Route::get('/about', function () {
    return view('about');
});


Route::get('/', function () {
    $posts = Post::orderBy('created_at', 'desc')->with('user')->with('likes')->get();

    return view('home', ['posts' => $posts]);
});