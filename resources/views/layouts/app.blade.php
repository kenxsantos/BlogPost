<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>
   
    <title>Laravel App - @yield('title')</title>
</head>
<body>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3  px-md-4 bg-white border-bottom shadow-sm mb-3">
        <h5 class="my-0 mr-md-auto font-weight-normal">Laravel APP</h5>
        <nav class="my-2 my-md-0 mr-md-3"> 
            <a class="p-2 text-dark text-decoration-none" href="{{ route('home.index') }}">Home</a>
            <a class="p-2 text-dark text-decoration-none" href="{{ route('home.contact') }}">Contact</a>
            <a class="p-2 text-dark text-decoration-none" href="{{ route('posts.index') }}">Blog Post</a>
            <a class="p-2 text-dark text-decoration-none" href="{{ route('posts.create') }}">Add Blog Post</a>
        </nav>
    </div>
    <div class="container ">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>