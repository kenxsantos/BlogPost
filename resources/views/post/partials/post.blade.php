
<h3><a href="{{ route('posts.show', ['post' => $post -> id]) }}">{{ $post->title }}</a></h3>

<div class="mb-3">
   <a href="{{ route('posts.edit', ['post' => $post -> id]) }}" class="btn btn-primary">Edit</a>
   <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
      @csrf
      @method('DELETE')
      <input class="btn btn-primary" type="submit" value="Delete" >
   </form>
</div>
