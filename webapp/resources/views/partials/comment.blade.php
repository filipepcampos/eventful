<div class="row">
    <div>
        <h1 class="d-inline-block mr-1">{{$comment->author()->get()->first()->username}}</h1>
        @can('delete', $comment)
            <a class="btn btn-outline-danger mb-3" onclick="deleteComment('{{ $comment->id }}')">Delete</a>
        @endcan
    </div>
    <p>{{$comment->creation_date}}</p>
    <p>{{$comment->content}}</p>
</div>