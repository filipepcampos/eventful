@extends('layouts.app')

@section('content')
<h1>EVENTS, YAY, THIS WILL WORK</h1>
<section id="whatever">
    @foreach ($events as $event)
        <p>{{ $event->title }}</p>
    @endforeach
</section>
@endsection
