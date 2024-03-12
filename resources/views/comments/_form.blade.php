<div class="mb-2 mt-2">
    @auth
        <form action="{{ route('posts.comments.store', ['post' => $post->id])}}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <textarea class="form-control" name="content" id="content"></textarea>
            </div>
            <div class="d-grid gap-2 mt-1">
                <input class="btn btn-primary" type="submit" value="Add">
            </div>
        </form>
        @errors
            
        @enderrors
    @else
        <a class="text-decoration-none" href="{{ route('login') }}">
            Sign
        </a>in to comment
    @endauth
    <hr>
</div>
