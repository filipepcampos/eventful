@extends('layouts.form')

@section('title', 'Login')

@section('form-content')
<form method="POST" action="{{ route('register') }}">
  {{ csrf_field() }}

  <div class="form-group mb-3">
    <label for="username">Username</label>
    <input id="username" class="form-control @if($errors->has('username')) is-invalid @endif" type="text" name="username" value="{{ old('username') }}" placeholder="Enter username" required>
    @if ($errors->has('username'))
    <div class="invalid-feedback d-block">
      {{ $errors->first('username') }}
    </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="name">Name</label>
    <input id="name" class="form-control @if($errors->has('name')) is-invalid @endif" type="text" name="name" value="{{ old('name') }}" placeholder="Enter name" required autofocus>
    @if ($errors->has('name'))
    <div class="invalid-feedback d-block">
      {{ $errors->first('name') }}
    </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="email">Email Address</label>
    <input id="email" class="form-control @if($errors->has('email')) is-invalid @endif" type="email" name="email" value="{{ old('email') }}" placeholder="Enter email" required>  
    @if ($errors->has('email'))
    <div class="invalid-feedback d-block">
      {{ $errors->first('email') }}
    </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="birthdate">Birthdate</label>
    <input id="birthdate" class="form-control @if($errors->has('birthdate')) is-invalid @endif" type="date" name="birthdate" value="{{ old('birthdate') }}" required>
    @if ($errors->has('birthdate'))
    <div class="invalid-feedback d-block">
      {{ $errors->first('birthdate') }}
    </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="password">Password</label>
    <input id="password" class="form-control @if($errors->has('password')) is-invalid @endif" type="password" name="password" placeholder="Enter password" required>
    @if ($errors->has('password'))
    <div class="invalid-feedback d-block">
      {{ $errors->first('password') }}
    </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" class="form-control" type="password" name="password_confirmation" required>
  </div>

  <button type="submit" class="btn btn-primary">
    Register
  </button>
</form>
@endsection
