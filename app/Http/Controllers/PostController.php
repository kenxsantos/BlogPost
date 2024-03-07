<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Gate;

    // Policy methods should use
    // [
    //     'show' => 'view'
    //     'create' => 'create'
    //     'store' => 'create'
    //     'edit' => 'update'
    //     'update' => 'update'
    //     'destroy' => 'delete'
    // ]
class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
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
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)){
        //     abort(403, 'You cant edit this post');
        // };

        //can remove update convention
        $this->authorize('update', $post);

        return view('post.edit', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request,  $id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)){
        //     abort(403, 'You cant edit this post');
        // };

         //can remove update convention
        $this->authorize('update', $post);
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

        // if (Gate::denies('delete-post', $post)){
        //     abort(403, 'You cant delete this post');
        // };

         //can remove delete convention
        $this->authorize('delete', $post);
        $post->delete();

        session()->flash('status', 'Blog Post was Deleted' . ' ID: ' . $id);

        return redirect()->route('posts.index');
    }
}
