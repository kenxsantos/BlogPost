@extends('layouts.app')

@section('title', 'Blog Post')



@section('content')
{{-- @each('post.partials.post', $posts, 'post') --}}
    @forelse ($posts as $key => $post)
        @include('post.partials.post', [])
    @empty
        No found Post
    @endforelse
    

@endsection
