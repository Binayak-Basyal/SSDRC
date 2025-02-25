<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index()
    {
        return BlogPost::latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'author' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new BlogPost();
        $post->title = $validated['title'];
        $post->slug = Str::slug($validated['title']);
        $post->content = $validated['content'];
        $post->author = $validated['author'];
        
        if($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blog_images', 'public');
            $post->featured_image = $path;
        }

        $post->save();

        return response()->json($post, 201);
    }

    public function show(BlogPost $blogPost)
    {
        return $blogPost;
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        // Similar to store with update logic
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();
        return response()->noContent();
    }
}