@extends('layouts.base')

@section('title', 'Update Profile')

@section('content')
<h1>Update Profile</h1>
<form method="post" action="{{ route('updateUser', ['user_id' => $user->id]) }}" enctype="multipart/form-data">
    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <label for="username" class="form-label">Username</label>
    <input id="username" type="text" name="username" placeholder="{{ $user->username }}" class="form-control">
    @if ($errors->has('username'))
        <span class="error">
          {{ $errors->first('username') }}
        </span>
    @endif

    <label for="Name" class="form-label">Name</label>
    <input id="name" type="text" name="name" placeholder="{{ $user->name }}" class="form-control" required>
    @if ($errors->has('name'))
        <span class="error">
          {{ $errors->first('name') }}
        </span>
    @endif

    <label class="form-label" for="profile_pic">Profile Picture</label>
    <input type="file" name="profile_pic" class="form-control-file" id="profile_pic" accept="image/*">
    @if ($errors->has('profile_pic'))
        <span class="error">
          {{ $errors->first('profile_pic') }}
        </span>
    @endif

    <label for="description" class="form-label">Description</label>
    <input id="description" type="textarea" name="description" placeholder="{{ $user->description }}" class="form-control">
    @if ($errors->has('description'))
        <span class="error">
          {{ $errors->first('description') }}
        </span>
    @endif

    <label for="email" class="form-label">Email</label>
    <input id="email" type="email" name="email" placeholder="{{ $user->email }}" class="form-control">
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" class="form-label">Password</label>
    <input id="password" type="password" name="password" placeholder="{{ $user->password }}" class="form-control">
    @if ($errors->has('password'))
        <span class="error">
          {{ $errors->first('password') }}
        </span>
    @endif
    
    <label for="birthdate" class="form-label">Birthdate</label>
    <input id="birthdate" type="datetime-local" name="birthdate" placeholder="{{ $user->birthdate }}" class="form-control">
    @if ($errors->has('birthdate'))
        <span class="error">
          {{ $errors->first('birthdate') }}
        </span>
    @endif

    <button type="submit" class="btn btn-primary">
        Submit
    </button>
</form>
@endsection
