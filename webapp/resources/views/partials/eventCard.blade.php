@can('viewInformation', $event)
<div class="col-auto mb-5">
    <div class="card h-100">
      <img class="card-img-top" src='{{ url("/image/event/$event->id") }}' alt="Event image">
      <div class="card-body">
        <h5 class="card-title">{{ $event->title }}</h5>
        <p class="card-text">{{ $event->description }}</p>
        <p class="card-text">{{ $event->is_visible ? 'Visible' : 'Not visible' }}</p>
      </div>
      <div class="card-footer">
        <a href="/event/{{ $event->id }}" class="btn btn-primary ml-auto">Event page</a>
        @cannot('viewContent', $event)
          @if($event->is_accessible)
            <a href="/event/{{ $event->id }}" class="btn btn-success ml-auto">Join event</a>
          @else()
            <a href="/event/{{ $event->id }}" class="btn btn-danger ml-auto">Request to join</a>
          @endif
        @endcan
      </div>
    </div>
</div>
@endcan