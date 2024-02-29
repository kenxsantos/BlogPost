@extends('layouts.app') 

@section('title', 'Create a Post')

@section('content')
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        @include('post.partials.form')
        <div><input type="submit" value="create"></div>
    </form>
@endsection
