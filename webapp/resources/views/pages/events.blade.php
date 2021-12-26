@extends('layouts.app')

@section('content')
<h1>Events</h1>
<section id="events">
    @foreach ($events as $event)
        <p>{{ $event->title }}</p>
    @endforeach
</section>
@endsection
