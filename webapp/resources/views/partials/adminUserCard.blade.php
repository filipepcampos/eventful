<div class="col-auto mb-3 userCardCol">
    <div id="userCard{{ $user->id }}" class="rounded-lg shadow card @if($user->block_motive!=null) border-secondary border-1 @endif" style="width: 26rem; box-sizing: border-box;">
        <img class="card-img-top" src='{{ url("/user/$user->id" . "/profile_pic") }}' alt="Profile Picture">
        <div class="card-body">
            <h5 class="card-title">{{ $user->username }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $user->name }}</h6>
            <div>
                <span class="class-text">
                    <i class="bi bi-envelope"></i>
                    {{ $user->email }}
                </span>
            </div>
            <div>
                <span class="class-text">
                    <i class="bi bi-calendar"></i>
                    {{ $user->birthdate }}
                </span>
            </div>
        </div>
        <div class="card-footer">
            <a role="button" class="btn btn-outline-primary" href="{{ url('/user/' . $user->id) }}">Profile</a>
            <a role="button" class="btn btn-outline-success" href="{{ route('updateUserForm', ['user_id' => $user->id]) }}">Edit</a>
            <a class="btn btn-outline-danger">Delete</a>
            @if($user->block_motive == null)
            <a role="button" class="btn btn-outline-secondary" id="blockButtonUser{{ $user->id }}" onclick="blockUser({{ $user->id }})">Block</a>
            @else
            <a role="button" class="btn btn-secondary" id="blockButtonUser{{ $user->id }}" onclick="unblockUser({{ $user->id }})">Unblock</a>
            @endif
        </div>
    </div>
</div>