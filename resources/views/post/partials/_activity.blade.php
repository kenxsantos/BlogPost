<div class="container">
    <div class="row mb-3">
        @card(['title' => 'Most Commented'])
            @slot('subtitle')
                What people are currently talking
            @endslot
            @slot('items')
                @foreach ($mostCommented as $post)
                    <li class="list-group-item">
                        <a class="text-decoration-none" href="{{ route('posts.show', ['post' => $post->id]) }}">
                            {{ $post->title }}
                        </a>
                    </li>
                @endforeach
            @endslot
        @endcard
    </div>
    <div class="row mb-3">
        @card(['title' => 'Most Active User'])
            @slot('subtitle')
                List of active users
            @endslot
            @slot('items', collect($mostActive)->pluck('name'))
        @endcard
    </div>
    <div class="row mb-3">
        @card(['title' => 'Most Active User Last Month'])
            @slot('subtitle')
                List of active users last month
            @endslot
            @slot('items', collect($mostActiveLastMonth)->pluck('name'))
        @endcard
    </div>
</div>
