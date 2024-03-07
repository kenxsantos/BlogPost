@extends('layouts.app')

@section('title', 'Contact Page')
@section('content')
    <h1>Contact Page</h1>
    <p>This is contact page</p> 

    @can('home.secret')
        <a href="{{ route('home.secret') }}">
            <p>Special contact details</p>
        </a>
    @endcan
@endsection
