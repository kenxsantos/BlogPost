<h3>
    @if ($post->trashed())
        <del>
    @endif
    <a class="{{ $post->trashed() ? 'text-muted' : 'text-decoration-none' }}"
        href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
    @if ($post->trashed())
        </del>
    @endif
</h3>
{{-- <p class="text-muted">
    Added by {{ $post->created_at->diffForHumans() }}
    @if ($post->user)
        by {{ $post->user->name }}
    @else
        by Unknown User
    @endif
</p> --}}

@updated(['date' => $post->created_at, 'name' => $post->user->name, 'userId' => $post->user->id])
@endupdated

@tags(['tags' => $post->tags])

@endtags

@if ($post->comments_count)
    <p>{{ $post->comments_count }} comments</p>
@else
    <p>No Comments</p>
@endif


<div class="mb-3">
    @auth
        @can('update', $post)
            <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
        @endcan
    @endauth
    {{-- 
   @cannot('delete', $post)
       <p>You cannot delete this post!</p>
   @endcannot   --}}
    @auth
        @if (!$post->trashed())
            @can('delete', $post)
                <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-primary" type="submit" value="Delete">
                </form>
            @endcan
        @endif
    @endauth
</div>
