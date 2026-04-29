<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\SavedPost;

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
    // J'ai utilisé Claude (web) pour m'aider à construire cette fonction
    // Fonctionnement: on vérifie que l'utilisateur est authentifié.
    // On cherche dans les posts enregistrés un post qui a le même utilisateur 
    // et même id de post que celui qu'on veut enregistrer. Si oui, on le retire (toggle). 
    // Si pas trouvé, on crée un enregistrement de post et on redirige vers le post (visualisation) 
    // concerné quand c'est fini.
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
    public function destroy(SavedPost $savedPost)
    {
        $user = Auth::user();

        $savedPost->delete();

        return redirect("/saved-posts");
    }
}
