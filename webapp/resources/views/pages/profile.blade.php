@extends('layouts.app')

@section('title', $user->username)

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col">
            <img class="border border-5 border-secondary rounded" src='{{ url("user/$user->id/profile_pic") }}' alt="Profile Picture">
        </div>
        <div class="col border border-5 border-secondary rounded">
            <h1 class="display-5 text-center">{{ $user->username }}</h1>
        </div>
    </div>
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