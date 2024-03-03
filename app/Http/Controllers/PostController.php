<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Faker\Core\Blood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // DB::connection()->enableQueryLog();

        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post){
        //     foreach ($post->comments as $comment){
        //         echo $comment->content;
        //     }
        // }
        // dd(DB::getQueryLog());

        return view('post.index', ['posts' => BlogPost::withCount('comments')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $post = BlogPost::create($validated);

        return redirect()->route('posts.show', ['post' => $post->id])->with('status', 'The blog post was created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        BlogPost::findOrFail($id); // Fetch the post using the $id parameter
        return view('post.show', ['post' => BlogPost::with('comments')->findOrFail($id)]);
        // abort_if(!isset($this->posts[$id]), 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('post.edit', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request,  $id)
    {
        $post = BlogPost::findOrFail($id);
        $validated = $request->validated();

        $post->fill($validated);
        $post->save();

        return redirect()->route('posts.show', ['post' => $post->id])->with('status', 'The blog post was updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

        session()->flash('status', 'Blog Post was Deleted' . ' ID: ' . $id);

        return redirect()->route('posts.index');
    }
}
