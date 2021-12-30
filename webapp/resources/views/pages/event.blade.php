@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col">
            <img class="border border-5 border-secondary rounded" src='{{ url("/image/event/$event->id") }}' alt="Event image">
        </div>
        <div class="col border border-5 border-secondary rounded">
            <h1 class="display-5 text-center">{{ $event->title }}</h1>

            @can('join', $event)
            <form method="post" action='{{ route("joinEvent", ["event_id" => $event->id]) }}'>
                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">
                    Join
                </button>
            </form>
            @elsecan('leave', $event)
            <form method="post" action='{{ route("leaveEvent", ["event_id" => $event->id]) }}'>
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger">
                    Leave
                </button>
            </form>
            @endcan
        </div>
    </div>
    <div class="row my-5">
        <h2 class="display-4">Description</h2>
        <p>{{ $event->description }}</p>
    </div>
    @can('viewContent', $event)
    <div class="row my-5">
        <div class="col-5">
            @include('partials.comments', ['comments' => $event->comments()->orderBy('creation_date', 'DESC')->get()])
        </div>
        <div class="col">
            @include('partials.posts', ['posts' => $event->posts()->orderBy('creation_date', 'DESC')->get()])
        </div>
    </div>
    @endcan
</div>
@endsection
