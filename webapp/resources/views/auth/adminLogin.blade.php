@extends('layouts.form')

@section('title', 'Login')

@section('form-content')
<form method="POST" action="{{ route('adminLogin') }}">
    {{ csrf_field() }}
    
    <div class="form-group mb-3">
        <label for="username">Username</label>
        <input type="username" class="form-control @if($errors->has('username')) is-invalid @endif" name="username" id="username" aria-describedby="usernameHelp" placeholder="Enter username" value="{{ old('username') }}" required autofocus>
        @if ($errors->has('username'))
        <div class="invalid-feedback d-block">
            {{ $errors->first('username') }}
        </div>
        @endif
    </div>

    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input type="password" class="form-control  @if($errors->has('password')) is-invalid @endif" name="password" id="password" placeholder="Enter password" value="{{ old('password') }}" required>
        @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form>
@endsection


