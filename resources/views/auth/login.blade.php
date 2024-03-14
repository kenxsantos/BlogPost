@extends('layouts.app')

@section('title', 'Log In')
@section('content')
<h1>Log In</h1>
    <form action="{{ route('login') }}" method="POST">
        @csrf
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
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
        </div>
        <div class="d-grid">
            <input type="submit" value="Log In" class="btn btn-primary btn-block mt-10">
        </div>
        

    </form>
@endsection
