@forelse ($comments as $comment)
<div>
    <h5 class="ml-2">{{ $comment->content }}</h5>

    @tags(['tags' => $comment->tags])@endtags
    @updated (['date' => $comment->created_at, 'name' => $comment->user->name, 'userId' => $comment->user->id])
    @endupdated
</div>

@empty
<p>Be the first one to comment!</p>
@endforelse