@extends('layouts.form')

@section('title', 'Login')

@section('form-content')
<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('email') }}" required autofocus>
    </div>
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" id="password" placeholder="Enter password" value="{{ old('password') }}" required>
    </div>
    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="checkbox">Remember me</label>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form>
@endsection


