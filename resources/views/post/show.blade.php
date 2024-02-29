@extends('layouts.app')

@section('title', $post['title'])

@if ($post['is_new'])
    <div>A new blog post! Using If</div>
@else 
    <div>Blog Post is old! using else</div>
@endif

@unless ($post['is_new'])
    <div>It is an old post using unless</div>
@endunless

@isset($post['has_comments'])
    <div>Postt has comments using isset</div>
@endisset

@section('content')
    <h1>{{ $post['title'] }}</h1>
    <p>{{ $post['content'] }}</p>
@endsection
