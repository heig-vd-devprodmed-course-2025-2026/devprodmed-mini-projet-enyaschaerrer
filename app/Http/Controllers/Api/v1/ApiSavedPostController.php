<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\SavedPost;

class ApiSavedPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); 
	    
        // latest = raccourci pour orderBy('created_at', 'desc')
        $savedPosts = $user->savedPosts()->with('post')->latest()->get();
            
        return $savedPosts;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $post = Post::findOrFail($request->post_id);
        
        $savedPost = new SavedPost();

        // enregistre le post chez l'utilisateur connecté. donc pas besoin de la Policy, 
        // car personne peut enregister un post chez qqn d'autre
        $savedPost->user_id = $user->id;
        $savedPost->post_id = $post->id;
        $savedPost->save();

        return $savedPost;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $savedPost = SavedPost::findOrFail($id);
        
        // seulement la personne qui a enregistré le post peut le désenregistrer
        Gate::authorize('delete', $savedPost);

        $savedPost->delete();

        return response()->noContent();
    }
}
