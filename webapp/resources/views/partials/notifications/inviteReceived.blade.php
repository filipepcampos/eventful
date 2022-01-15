You've been invited to join the event "<strong>{{ $notification->data['event'] }}</strong>".
<div class="mt-2 pt-2 border-top">
    <form id="joinEventForm" method="POST" style="display: inline;" action="{{ route('joinEvent', ['event_id' => $notification->data['event_id'] ]) }}">
        {{ csrf_field() }}
        <a onclick="document.getElementById('joinEventForm').submit();" type="submit" class="btn btn-success ml-auto">Join event</a>
    </form>
    <a href="{{ url('/event/' . $notification->data['event_id']) }}" class="btn btn-secondary ml-auto">Event page</a>
</div>