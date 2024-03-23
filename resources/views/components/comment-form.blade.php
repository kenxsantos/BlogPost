<div class="mb-2 mt-2">
    @auth
        <form action="{{ $route }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <textarea class="form-control" name="content" id="content"></textarea>
            </div>
            <div class="d-grid gap-2 mt-1">
                <input class="btn btn-primary" type="submit" value="Add Comment">
            </div>
        </form>
        @errors
            
        @enderrors
    @else
        <a class="text-decoration-none" href="{{ route('login') }}">
            Sign
        </a>in to post comment!
    @endauth
    <hr>
</div>
