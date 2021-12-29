@extends('layouts.app')

@section('content')
<div class="container w-50">
  <form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <div class="form-group">
      <label for="username">Username</label>
      <input id="username" class="form-control" type="text" name="username" value="{{ old('username') }}" placeholder="Enter username" required>
    </div>
    @if ($errors->has('username'))
      <span class="error">
          {{ $errors->first('username') }}
      </span>
    @endif

    <div class="form-group">
      <label for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter name" required autofocus>
    </div>
    @if ($errors->has('name'))
      <span class="error">
          {{ $errors->first('name') }}
      </span>
    @endif

    <div class="form-group">
      <label for="email">Email Address</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter email" required>  
    </div>
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <div class="form-group">
      <label for="birthdate">Birthdate</label>
      <input id="birthdate" type="date" name="birthdate" value="{{ old('birthdate') }}" required>
    </div>
    @if ($errors->has('birthdate'))
      <span class="error">
          {{ $errors->first('birthdate') }}
      </span>
    @endif

    <div class="form-group">
      <label for="password">Password</label>
      <input id="password" type="password" name="password" placeholder="Enter password" required>
    </div>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <div class="form-group">
      <label for="password-confirm">Confirm Password</label>
      <input id="password-confirm" type="password" name="password_confirmation" required>
    </div>

    <button type="submit" class="btn btn-primary">
      Register
    </button>
  </form>
</div>
@endsection
