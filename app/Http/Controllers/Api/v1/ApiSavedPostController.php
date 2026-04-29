<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        return $post;
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
        $user = Auth::user();

        $savedPost->delete();

        return response()->noContent();
    }
}
