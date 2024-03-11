@extends('layouts.app')

@section('title', 'Blog Post')



@section('content')
    {{-- @each('post.partials.post', $posts, 'post') --}}
    <div class="row">
        <div class="col-8">
            @forelse ($posts as $key => $post)
                @include('post.partials._post', [])
            @empty
                No found Post
            @endforelse
        </div>
        <div class="col-4">
            @include('post.partials._activity', [])
        </div>
    </div>
@endsection
