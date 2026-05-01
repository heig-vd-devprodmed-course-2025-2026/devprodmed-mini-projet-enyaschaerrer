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
    // On cherche dans les posts s'il y a le post avec l'id qui est passé dans le corps de la requête.
    // Si trouvé, on crée un enregistrement de post et on redirige vers le post (visualisation) 
    // concerné quand c'est fini.
    public function store(Request $request) {
    
        $user = Auth::user();
        $post = Post::findOrFail($request->post_id);
        
        $savedPost = new SavedPost();

        // enregistre le post chez l'utilisateur connecté. donc pas besoin de la Policy, 
        // car personne peut enregister un post chez qqn d'autre
        $savedPost->user_id = $user->id;
        $savedPost->post_id = $post->id;
        $savedPost->save();

        return redirect("posts/$post->id");
    }

    // Supprime un post sauvegardé
    public function destroy(string $id)
    {
        $savedPost = SavedPost::findOrFail($id);
        
        // seulement la personne qui a enregistré le post peut le désenregistrer
        Gate::authorize('delete', $savedPost);

        $savedPost->delete();

        // comme ça j'ai 2 comportements différents : quand je supprime depuis posts show, ca reste sur le post. 
        // quand je supprime depuis la liste des enregistrements qui s'accède depuis le profil, ça reste sur la liste des enregistrés
        return back();
    }
}
