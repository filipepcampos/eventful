@can('viewInformation', $event)
<div class="col-auto mb-5 rounded-lg">
    <div class="card h-100 @can('isHost', $event) border-success border-2 @elsecan('isAttendee', $event) border-primary border-2 @endcan rounded shadow-lg">
      <img class="card-img-top" src='{{ url("/event/$event->id" . "/image") }}' alt="Event image">
      <div class="card-body d-flex flex-column">
        <h3 class="card-title"><b>{{ $event->title }}</b></h3>
        <p class="card-text">{{ $event->description }}</p>
        <div class="mt-auto">
          @include('partials.eventTags', ['tags' => $event->tags()->get()])
          @include('partials.eventDetails', ['event' => $event])
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ url('/event/' . $event->id) }}" class="btn btn-secondary ml-auto">Event page</a>
        @can('join', $event)
          @if($event->realization_date->isFuture())
            @if($event->is_accessible)
              <form id="joinEventForm" method="POST" style="display: inline;" action="{{ route('joinEvent', ['event_id' => $event->id]) }}">
                {{ csrf_field() }}
                <a onclick="document.getElementById('joinEventForm').submit();" type="submit" class="btn btn-success ml-auto">Join event</a>
              </form>
            @elseif(Auth::check() && is_null($event->requests()->where('user_id', Auth::user()->id)->first()))
              <a id="request{{ $event->id }}" onclick="sendRequest('{{ $event->id }}')" class="btn btn-danger ml-auto">Request to join</a>
            @endif
          @endif
        @endcan
        @can('isHost', $event) 
          <span class="text-success float-right">Hosting</span>
        @elsecan('isAttendee', $event)
          <span class="text-primary float-right">Attending</span>
        @endcan
      </div>
    </div>
</div>
@endcan