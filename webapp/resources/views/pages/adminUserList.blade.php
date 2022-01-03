@extends('layouts.adminBase')

@section('title', 'User Management')

@section('content')
<script type="text/javascript" src="{{ asset('/js/administration.js') }}" ></script>
<div class="container mt-5">
    <div class="jumbotron text-center mb-5">
        <h1 class="display-2">User Management</h1>
    </div>
    <div class="row justify-content-center">
    @each('partials.adminUserCard', $users, 'user')
    </div>
    <div class="row justify-content-center">
        {{ $users->render() }}
    </div>
</div>


@endsection
