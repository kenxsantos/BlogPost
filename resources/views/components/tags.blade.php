<p>
    @foreach ($tags as $tag)
        <a 
        href= {{ route('posts.tags.index', ['tag' => $tag->id]) }} 
        class="badge bg-primary text-decoration-none fs-6">
            {{ $tag->name }}
        </a>
    @endforeach
</p>