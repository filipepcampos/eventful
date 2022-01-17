<div id="commentRow{{ $comment->id }}" class="row">
    <div>
        <img class="img-fluid rounded-circle me-2" style="height:3em;" src="{{ route('userImage', ['user_id' => $comment->author()->get()->first()->id]) }}">
        <p class="d-inline-block">{{$comment->author()->get()->first()->username}}</p>
        @can('deleteComment', $comment)
            <a class="btn btn-outline-danger ms-3 mt-3 mb-3" onclick="deleteComment('{{ $comment->id }}')">Delete</a>
        @endcan
    </div>
    <p class="mb-0">{{$comment->creation_date}}</p>
    <div class="mb-2">
        <span>
            <i id="upvote{{ $comment->id }}" class="bi bi-hand-thumbs-up{{ $comment->ratings()->where('user_id', '=', Auth::id())->where('vote', '=', 'Upvote')->first() ? '-fill' : '' }} me-2" style="font-size: 1.5rem" onclick="addRatingComment({{ $comment->id }}, true);"></i>
            <span id ="upvotes{{ $comment->id }}">{{ $comment->number_upvotes }}</span>
        </span>
        <span>
            <i id ="downvote{{ $comment->id }}" class="bi bi-hand-thumbs-down{{ $comment->ratings()->where('user_id', '=', Auth::id())->where('vote', '=', 'Downvote')->first() ? '-fill' : '' }} me-2" style="font-size: 1.5rem" onclick="addRatingComment({{ $comment->id }}, false);"></i>
            <span id="downvotes{{ $comment->id }}">{{ $comment->number_downvotes }}</span>
        </span>
    </div>
    <p>{{$comment->content}}</p>
    @foreach($comment->files()->get() as $file)
        <a href="{{ asset('storage/'.$file->path) }}">{{ $file->original_name }}</a>
    @endforeach
</div>