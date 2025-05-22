<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user'])
            ->withCount('claps')
            ->latest()
            ->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('post.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title' => 'required',
            'content' => 'required',
            'category_id' => ['required', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
        ]);

        $image = $data['image'];
        unset($data['image']);
        $data['user_id'] = Auth::id();

        $imagePath = $image->store('posts', 'public');
        $data['image'] = $imagePath;

        Post::create($data);

        return redirect()->route('dashboard')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username, Post $post)
    {
        return view('post.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }
        $categories = Category::get();  
        return view('post.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $data = $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title' => 'required',
            'content' => 'required',
            'category_id' => ['required', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
        ]);

        // Check if image exists in the request and is not null
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $data['image'];
            unset($data['image']);

            $imagePath = $image->store('posts', 'public');
            $data['image'] = $imagePath;
        }

        $post->update($data);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }
        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }

    public function category(Category $category)
    {
        $posts = $category->posts()
            ->with(['user', 'category'])
            ->withCount('claps')
            ->latest()
            ->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
            'category' => $category,
        ]);
    }

    public function myPosts()
    {
        $user = auth()->user();
        $posts = $user->posts()
            ->with(['user'])
            ->withCount('claps')
            ->latest()->simplePaginate(5);
        return view('post.my-posts', [
            'posts' => $posts,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $posts = Post::with(['user', 'category'])
            ->where(function($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('content', 'like', "%$search%")
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('category', function($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            })
            ->withCount('claps')
            ->latest()
            ->simplePaginate(5)
            ->appends(['search' => $search]);
        
        return view('post.index', [
            'posts' => $posts,
            'search' => $search
        ]);
    }
}
