<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavedPostController extends Controller
{
    // Affiche tous les posts sauvegardés de l'utilisateur connecté
    public function index() {
    
	    $user = Auth::user(); 
	    
        // latest = raccourci pour orderBy('created_at', 'desc')
        $savedPosts = $user->savedPosts()->with('post')->latest()->get();
            
        return view('saved-posts.index', ['savedPosts' => $savedPosts]);
    }

    // Sauvegarde un post (toggle)
    public function store(Post $post) {
    
        $user = Auth::user();
        
        // si le post était déjà sauvegardé
        $existing = SavedPost::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            $savedPost = new SavedPost();
            $savedPost->user_id = $user->id;
            $savedPost->post_id = $post->id;
            $savedPost->save();
        }

        return redirect("posts/$post->id");
    }

    // Supprime un post sauvegardé
    public function destroy(Post $post)
    {
        $user = Auth::user();

        SavedPost::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->delete();

        return redirect("/posts/$post->id");
    }
}
