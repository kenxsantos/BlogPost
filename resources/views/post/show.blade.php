@extends('layouts.app')

@section('title', $post->title)


@section('content')
    <div class="row">
        <div class="col-8">
            <h1>{{ $post->title }}
                @badge(['type' => 'primary', 'show' => now()->diffInMinutes($post->created_at) < 10])
                    New Post!
                @endbadge
            </h1>
        
            <p>{{ $post->content }}</p>
        
            @updated(['date' => $post->created_at, 'name' => $post->user->name])
            @endupdated
        
            @updated(['date' => $post->updated_at])
                Updated
            @endupdated
        
            @tags(['tags' => $post->tags])
            @endtags
        
            <p>Currently read by {{ $counter }} people</p>
        
            <h4>Comments</h4>
            @forelse ($post->comments as $comment)
                <div>
                    <h5 class="ml-2">{{ $comment->content }}</h5>
                    @updated(['date' => $post->created_at])
                    @endupdated
                </div>
        
            @empty
                <p>Be the first one to comment!</p>
            @endforelse
        </div>
        <div class="col-4">
            @include('post.partials._activity', [])
        </div>
    </div>
@endsection
