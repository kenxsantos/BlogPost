<div class="form-group mb-3">
    <label for="title">Title</label>
    <input id="title" type="text" name="title" class="form-control" value="{{ old('title', optional($post ?? null)->title) }}">
</div>
@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<div class="form-group mb-3">
    <label for="content">Content</label>
    <textarea class="form-control" name="content" id="content">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>
@if ($errors->any())
    <div>
        <ul class="list-group">
            @foreach ($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
