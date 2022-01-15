@if(Auth::check())
    <div style="position: absolute;top: 10%; right: 0; z-index:1;">
    <div class="toast mb-1" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" id="noNotificationsToast" hidden>
        <div class="toast-header">
            <strong class="me-auto">No notifications</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            You've caught up with the news :)
        </div>
    </div>
    @foreach(Auth::user()->unreadNotifications as $notification)
    <div class="toast mb-1" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" id="notification{{$notification->id}}">
        <div class="toast-header">
            <!--<img src="..." class="rounded me-2" alt="...">-->
            <strong class="me-auto">{{ $notification->data['title'] }}</strong>
            <small>{{ $notification->created_at->diffForHumans() }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" onclick="markAsRead('{{ Auth::id() }}', '{{$notification->id}}')"></button>
        </div>
        <div class="toast-body">
            @switch($notification->type)
                @case('App\Notifications\InviteReceived')
                    @include('partials.notifications.inviteReceived', ['notification' => $notification])
                @break
            @endswitch
        </div>
    </div>
    @endforeach
    </div>
@endif

