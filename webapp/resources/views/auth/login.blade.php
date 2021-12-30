@extends('layouts.form')

@section('title', 'Login')

@section('form-content')
<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('email') }}" required autofocus>
    </div>
    @if ($errors->has('email'))
        <span class="error">
        {{ $errors->first('email') }}
        </span>
    @endif

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" value="{{ old('password') }}" required>
    </div>
    @if ($errors->has('password'))
    <span class="error">
        {{ $errors->first('password') }}
    </span>
    @endif

    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="checkbox">Remember me</label>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form>
@endsection


