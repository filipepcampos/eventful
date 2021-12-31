@extends('layouts.app')

@section('title', $event->title)

@section('content')

<!-- Modal -->
<div class="modal fade" id="attendees" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="attendeesLabel">Attendees</h5>
      </div>
      <div class="modal-body">
        @foreach($event->attendees()->get() as $user)
            <p>{{ $user->username }}</p>
            @can('update', $event)
            <button>Begone pleb</button>
            @endcan
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
    <div class="row my-5">
        <div class="col">
            <img class="border border-3 border-secondary rounded" src='{{ url("/image/event/$event->id") }}' alt="Event image">
        </div>
        <div class="col border border-3 border-secondary rounded">
            <h1 class="display-2 text-center">{{ $event->title }}</h1>
            <p class="lead text-center">Created by {{ $event->host()->first()->username }}<p>
            <div class="text-center">
            @include('partials.eventTags', ['tags' => $event->tags()->get()])                
            </div>

            <div class="row">
                <div class="col">
                    @include('partials.eventDetails', ['event' => $event])
                </div>
                <div class="col">
                    <div class="float-right">
                        <!-- Host buttons -->
                        @can('update', $event)
                        <a class="btn btn-secondary" href="">Update (Broken)</a>
                        @endcan

                        @can('delete', $event)
                        <a class="btn btn-danger" href="">Delete (Broken)</a>
                        @endcan

                        <!-- Regular user buttons -->
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

                        @can('viewInformation', $event)
                        <button class="btn btn-secondary" type="button" data-bs-toggle="modal" href="#attendees">View Attendees</button>
                        @endcan
                    </div>
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
