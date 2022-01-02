<!-- Modal -->
<div class="modal fade" id="invites" tabindex="-1" role="dialog" aria-labelledby="invitesLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="invitesLabel">Invites</h5>
      </div>
      <div class="modal-body">
        <div class="wrapper container">
        @foreach($user->invites()->get() as $invite)
            <div class="row align-content-start" id="invite{{ $invite->id }}">
                <div class="col">
                    <span>{{ $invite->inviter()->first()->username }} invites you to </span>
                    <a href="{{ url('/event/' . $invite->event()->first()->id) }}">{{ $invite->event()->first()->title }}</a>
                </div>
                <div class="col-sm">
                    <button onclick="accept({{$invite->id}})" class="btn btn-outline-success">
                    @if($invite->event()->first()->is_accessible)
                      Accept
                    @else
                      Request
                    @endif
                    </button>
                    <button onclick="reject({{$invite->id}})" class="btn btn-outline-danger">Reject</button>
                </div>
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