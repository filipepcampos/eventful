@can('viewInformation', $event)
<div class="col-auto mb-5 rounded-lg">
    <div class="card h-100 @can('host', $event) border-success border-2 @elsecan('attend', $event) border-primary border-2 @endcan rounded shadow-lg">
      <img class="card-img-top" src='{{ url("/event/$event->id" . "/image") }}' alt="Event image">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $event->title }}</h5>
        <p class="card-text">{{ $event->description }}</p>
        <div class="mt-auto">
          @include('partials.eventTags', ['tags' => $event->tags()->get()])
          @include('partials.eventDetails', ['event' => $event])
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ url('/event/' . $event->id) }}" class="btn btn-secondary ml-auto">Event page</a>
        @cannot('viewContent', $event)
          @if($event->realization_date->isFuture())
            @if($event->is_accessible)
              <a href="{{ url('/event/' . $event->id) }}" class="btn btn-success ml-auto">Join event</a>    <!-- TODO: Change url -->
            @else()
              <a id="request{{ $event->id }}" onclick="sendRequest({{ $event->id }})" class="btn btn-danger ml-auto">Request to join</a>
            @endif
          @endif
        @endcan
        @can('host', $event) 
        <span class="text-success float-right">Hosting</span>
        @elsecan('attend', $event)
        <span class="text-primary float-right">Attending</span>
        @endcan
      </div>
    </div>
</div>
@endcan