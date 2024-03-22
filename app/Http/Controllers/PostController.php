<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Redis;

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
    public function __construct()
    {
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

        return view(
            'post.index',
            [
                'posts' =>  BlogPost::latestWithRelations()->get(),
            ]
        );
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
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $post = BlogPost::create($validatedData);

        if($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
                $post->image()->save(
                    Image::make(['path' => $path])
                );   
        }
        $request->session()->flash('status', 'Blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the post using the $id parameter
        // return view('post.show', ['post' => BlogPost::with(['comments' => function ($query) {
        //     return $query->latest();
        // }])->findOrFail($id)]);

        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function () use ($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')
                ->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::tags(['blog-post'])->get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
        ) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);

        if (!Cache::tags(['blog-post'])->has($counterKey)) {
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        } else {
            Cache::tags(['blog-post'])->increment($counterKey, $difference);
        }


        $counter = Cache::tags(['blog-post'])->get($counterKey);

        return view('post.show', [
            'post' => $blogPost,
            'counter' => $counter,
        ]);
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

        if($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            
            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }else{
                $post->image()->save(
                    Image::make(['path' => $path])
                );
            }      
        }
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

        return redirect()->route('post.index');
    }
}
