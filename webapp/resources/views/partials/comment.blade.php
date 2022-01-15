<div id="commentRow{{ $comment->id }}" class="row">
    <div>
        <img class="img-fluid rounded-circle me-2" style="height:3em;" src="{{ route('userImage', ['user_id' => $comment->author()->get()->first()->id]) }}">
        <p class="d-inline-block">{{$comment->author()->get()->first()->username}}</p>
        @can('deleteComment', $comment)
            <a class="btn btn-outline-danger ms-3 mt-3 mb-3" onclick="deleteComment('{{ $comment->id }}')">Delete</a>
        @endcan
    </div>
    <p class="mb-0">{{$comment->creation_date}}</p>
    <div id="commentFeedback{{ $comment->id }}" class="mb-2">
        <span><i id ="upvotes" class="bi bi-arrow-up" style="font-size: 1.5rem"></i>{{ $comment->number_upvotes }}</span>
        <span><i id ="downvotes" class="bi bi-arrow-down" style="font-size: 1.5rem"></i>{{ $comment->number_downvotes }}</span>
    </div>
    <p>{{$comment->content}}</p>
</div>