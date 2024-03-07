<h3>
    <a class="text-decoration-none" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
</h3>
<p class="text-muted">
    Added by {{ $post->created_at->diffForHumans() }}
    @if ($post->user)
        by {{ $post->user->name }}
    @else
        by Unknown User
    @endif

</p>

@if ($post->comments_count)
    <p>{{ $post->comments_count }} comments</p>
@else
    <p>No Comments</p>
@endif


<div class="mb-3">
    @can('update', $post)
        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
    @endcan
    
{{-- 
   @cannot('delete', $post)
       <p>You cannot delete this post!</p>
   @endcannot   --}}

    @can('delete', $post)
        <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input class="btn btn-primary" type="submit" value="Delete">
        </form>
    @endcan

</div>
