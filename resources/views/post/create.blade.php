@extends('layouts.app') 

@section('title', 'Create a Post')

@section('content')
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        @include('post.partials.form')
        <div class="d-grid gap-2 mt-1">
            <input class="btn btn-primary" type="submit" value="create">
        </div>
    </form>
@endsection
