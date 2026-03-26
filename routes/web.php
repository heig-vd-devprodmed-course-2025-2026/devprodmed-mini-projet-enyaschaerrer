<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\AuthController;


Route::get('/about', function () {
    return view('about');
});


Route::get('/', function () {
    $posts = Post::orderBy('created_at', 'desc')->with('user')->with('likes')->get();

    return view('home', ['posts' => $posts]);
});

Route::get('/@{username}', [ProfileController::class, 'show'])->where('username', '[A-Za-z0-9-_]+');

Route::resource('posts', PostController::class)->except(['index', 'show'])->middleware('auth');
Route::resource('posts', PostController::class)->only(['index', 'show']);

Route::get('/', function () {
    $posts = Post::orderBy('created_at', 'desc')->with('user')->with('likes')->limit(3)->get();

    return view('home', ['posts' => $posts]);
});

Route::match(['put', 'patch'], '/likes/{post}', [LikeController::class, 'update'])->middleware('auth');

Route::singleton('my-profile', MyProfileController::class)->destroyable()->middleware('auth');

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/register', 'showRegister');
    Route::post('/auth/register', 'register');
});

Route::controller(AuthController::class)->group(function () {
    // ... autres routes ...
    Route::get('/auth/login', 'showLogin')->name('login');    
    Route::post('/auth/login', 'login');
});

Route::controller(AuthController::class)->group(function () {
    // ... autres routes ...
    Route::post('/auth/logout', 'logout')->middleware('auth');
});