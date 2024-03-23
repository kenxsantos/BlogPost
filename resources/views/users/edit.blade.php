@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data"
        class="form-horizontal">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : '' }}" alt="..." class="img-thumbnail avatar" style="width:128px; height:128px">
                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Upload a different photo</h6>
                        <input type="file" class="form-control-file" name="avatar">
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group mb-3">
                    <label for="">Name</label>
                    <input type="text" class="form-control" value="" name="name">
                </div>

                @errors @enderrors
                <div class="form-group">
                    <input type="submit" value="Save Changes" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>
@endsection
