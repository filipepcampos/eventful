@extends('layouts.base')

@section('title', $user->username)

@section('content')
<script type="text/javascript" src="{{ asset('/js/invitesManagement.js') }}" ></script>
@include('partials.invitesListModal', ['user' => $user])
<div class="container">
    <div class="row my-5">
        <div class="col">
            <img class="border border-5 border-secondary rounded" src='{{ url("user/$user->id/profile_pic") }}' alt="Profile Picture">
        </div>
        <div class="col border border-5 border-secondary rounded">
            <h1 class="display-5 text-center">{{ $user->username }}</h1>
            <button class="btn btn-secondary" type="button" data-bs-toggle="modal" href="#invites">View Invites</button>
        </div>
    </div>

    @can('update', $user)
    <div class="row mb-1">
    <form method="get" action='{{ route("updateUser", ["user_id" => $user->id]) }}'>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-secondary">
            Edit Profile
        </button>
    </form>
    </div>
    <a class="btn btn-secondary" href='{{ route("updateUserForm", ["user_id" => $user->id]) }}'>Edit Profile</a>
    @endcan

    <div class="row my-5">
        <h2 class="display-4">Birthdate</h2>
        <p>{{ $user->birthdate }}</p>
    </div>
    <div class="row my-5">
        <h2 class="display-4">Description</h2>
        <p>{{ $user->description }}</p>
    </div>
    
    <div class="row my-5">
        @each('partials.eventCard', $user->attending()->orderBy('realization_date', 'DESC')->get(), 'event')
    </div>
</div>
@endsection