@extends('layouts.app')
@section('content')
<h1>Register</h1>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="form-control  {{ $errors->has('name') ? ' is-invalid' : '' }}">
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>             
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="form-control  {{ $errors->has('email') ? ' is-invalid' : '' }}">
                @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>             
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password"
                class="form-control  {{ $errors->has('password') ? ' is-invalid' : '' }}">
                @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>             
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="form-control  {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                @if ($errors->has('password_confirmation'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>             
            @endif
        </div>
        <div class="d-grid">
            <input type="submit" value="Register" class="btn btn-primary btn-block mt-10">
        </div>

    </form>
@endsection
