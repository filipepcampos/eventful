@extends('layouts.base')

@section('title', $event->title)

@section('content')

<script type="text/javascript" src="{{ asset('/js/attendeeManagement.js') }}" ></script>
@can('viewContent', $event)
@include('partials.attendeeListModal', ['event' => $event])
@include('partials.inviteUserModal', ['event' => $event])
@endcan

<div class="container">
    <div class="row my-5">
        <div class="col">
            <img class="border border-3 border-secondary rounded" src='{{ url("/event/$event->id" . "/image") }}' alt="Event image">
        </div>
        <div class="col border border-3 border-secondary rounded">
            <h1 class="display-2 text-center">{{ $event->title }}</h1>
            <p class="lead text-center">Created by {{ $event->host()->first()->username }}<p>
            <div class="text-center">
            @include('partials.eventTags', ['tags' => $event->tags()->get()])                
            </div>

            <div class="row">
                <div class="col-sm">
                    @include('partials.eventDetails', ['event' => $event])
                </div>
                <div class="col-sm-3">
                    <!-- Host buttons -->
                    @can('update', $event)
                    <a class="btn btn-secondary mb-2 w-100" href="{{ route('updateEventForm', ['event_id' => $event->id]) }}">Update</a>
                    @endcan

                    @can('delete', $event)
                    <a class="btn btn-danger btn-disabled mb-2 w-100" href="">Delete (Disabled)</a>
                    @endcan

                    <!-- Regular user buttons -->
                    @can('join', $event)
                    <form method="post" action='{{ route("joinEvent", ["event_id" => $event->id]) }}'>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success mb-2 w-100">
                            Join
                        </button>
                    </form>
                    @elsecan('leave', $event)
                    <form method="post" action='{{ route("leaveEvent", ["event_id" => $event->id]) }}'>
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger mb-2 w-100">
                            Leave
                        </button>
                    </form>
                    @endcan

                    @can('viewContent', $event)
                    <button class="btn btn-secondary mb-2 w-100" type="button" data-bs-toggle="modal" href="#attendees">View Attendees</button>
                    <button class="btn btn-secondary mb-2 w-100" type="button" data-bs-toggle="modal" onclick="clearInviteFeedback()" href="#inviteUser">Invite</button>
                    @endcan
                </div>
            </div>
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
