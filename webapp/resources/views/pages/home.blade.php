@extends('layouts.app')

@section('title', 'Cards')

@section('content')

<h1> Hello </h1>

<a class="button button-outline" href="{{ route('login') }}">Login</a>
<a class="button button-outline" href="{{ route('register') }}">Register</a>

@endsection
