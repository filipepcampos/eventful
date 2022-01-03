<!-- Modal -->
<div class="modal fade" id="attendees" tabindex="-1" role="dialog" aria-labelledby="attendeesLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="attendeesLabel">Attendees</h5>
      </div>
      <div class="modal-body">
        <div class="wrapper container">
        @foreach($event->attendees()->get() as $user)
            <div class="row align-content-start" id="attendee{{ $user->id }}">
                <div class="col-sm">
                    <a  @can('update', $event) href="{{ url('/user/' . $user->id) }}" @endcan>{{ $user->username }}</a>
                </div>
                @can('update', $event)
                <div class="col-md">
                  <button onclick="kick({{$event->id}}, {{$user->id}})" class="btn btn-outline-danger">Kick</button>
                </div>
                @endcan
            </div>
        @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>