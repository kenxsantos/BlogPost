<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
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
                'posts' =>  BlogPost::latest()->withCount('comments')
                    ->with('user')->with('tags')->get(),
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
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $post = BlogPost::create($validated);

        return redirect()->route('posts.show', ['post' => $post->id])->with('status', 'The blog post was created!');
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

        $bloPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function () use ($id) {
            return BlogPost::with('comments')->with('tags')->with('user')->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::tags(['blog-post'])->get($usersKey,[]);
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

        if (!Cache::tags(['blog-post'])->has($counterKey)){
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        }else{
            Cache::tags(['blog-post'])->increment($counterKey, $difference);
        }
       

        $counter = Cache::tags(['blog-post'])->get($counterKey);

        return view('post.show', [
            'post' => $bloPost,
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
