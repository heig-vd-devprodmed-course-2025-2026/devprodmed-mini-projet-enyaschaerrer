<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\SavedPostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = Post::orderBy('created_at', 'desc')->with('user')->with('likes')->limit(3)->get();

    return view('home', ['posts' => $posts]);
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/@{username}', [ProfileController::class, 'show'])->where('username', '[A-Za-z0-9-_]+');

Route::resource('posts', PostController::class)->except(['index', 'show'])->middleware('auth');
Route::resource('posts', PostController::class)->only(['index', 'show']);

Route::singleton('my-profile', MyProfileController::class)->destroyable()->middleware('auth');

Route::match(['put', 'patch'], '/likes/{post}', [LikeController::class, 'update'])->middleware('auth');

// posts sauvegardés
// J'ai utilisé Claude (web) pour m'aider à clarifier quelle syntaxe je devrais utiliser pour déclarer mes routes,
// entre Route::resource, Route:: match, Route::controller, etc.
// Récap de ce que j'ai compris : Route::get/post/match c'est pour des routes isolées avec méthode HTTP précise.
// Route::resource pour générer toutes méthodes CRUD pour un contrôleur, puis on peut limiter avec only ou except.
// Route::singleton pour une ressource unique. 
// Route::controller pour plusieurs routes avec méthodes HTTP et URLs différentes mais qui partagent le même contrôleur.
// J'ai donc choisi Route::resource pour index et destroy car ça jouait bien et je trouvais le plus simple syntaxiquement à comprendre.
// Par contre, j'ai remarqué plus tard que je devais obtenir l'id du post à sauver quand qqn soumet le formulaire pour sauvegarder (post).
// Donc, j'ai fait une route séparée pour ça.
Route::resource('saved-posts', SavedPostController::class)->only(['index', 'destroy'])->middleware('auth');
Route::post('/saved-posts/{post}', [SavedPostController::class, 'store'])->middleware('auth');

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/register', 'showRegister');
    Route::post('/auth/register', 'register');
    Route::get('/auth/login', 'showLogin')->name('login');
    Route::post('/auth/login', 'login');
    Route::post('/auth/logout', 'logout')->middleware('auth');
});

Route::resource('tokens', TokenController::class)->only(['index', 'create', 'store', 'destroy'])->middleware('auth');


use App\Models\SavedPost;


// route de test
// Route::get('/test-saved_post', function () {
//     $saved_post= new SavedPost();

//     $saved_post->user_id = 1;
//     $saved_post->post_id = 1;

//     $saved_post->save();

//     return $saved_post;
// });