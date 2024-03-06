<h3>
   <a class="text-decoration-none" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
</h3>
   <p class="text-muted">
      Added by {{ $post->created_at->diffForHumans()}} by {{ $post->user->name }}
   </p>

   @if ($post->comments_count)
         <p>{{ $post->comments_count }} comments</p>
   @else
      <p>No Comments</p>
   @endif

<div class="mb-3">
    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
    <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <input class="btn btn-primary" type="submit" value="Delete">
    </form>
</div>
