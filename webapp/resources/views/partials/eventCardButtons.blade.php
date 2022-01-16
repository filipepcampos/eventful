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