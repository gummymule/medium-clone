<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SavedPostController extends Controller
{
    // In SavedPostController.php
    public function toggleSave(Post $post)
    {
        auth()->user()->savedPosts()->toggle($post->id);
        
        return response()->json(['success' => true]);
    }

    public function index()
    {
        $posts = auth()->user()->savedPosts()->latest()->paginate(10);
        return view('posts.saved', compact('posts'));
    }
}
