@extends('layouts.app') 

@section('title', 'Update a Post')

@section('content')
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('PUT')
        @include('post.partials._form')
        <div class="d-grid gap-2 mt-1">
            <input class="btn btn-primary" type="submit" value="update">
        </div>
    </form>
@endsection
