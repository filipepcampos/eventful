<div class="col-auto mb-3">
    <div class="card" style="width: 26rem;">
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
            <button class="btn btn-outline-success">Edit</button>
            <button class="btn btn-outline-danger">Delete</button>
            <button class="btn btn-outline-secondary">Block</button>
        </div>
    </div>
</div>