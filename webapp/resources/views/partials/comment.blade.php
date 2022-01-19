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
            @if(Auth::id() != $comment->author_id)
                <i id="upvote{{ $comment->id }}" class="bi bi-hand-thumbs-up{{ $comment->ratings()->where('user_id', '=', Auth::id())->where('vote', '=', 'Upvote')->first() ? '-fill' : '' }} me-2" style="font-size: 1.5rem" onclick="addRatingComment({{ $comment->id }}, true);"></i>
            @else
                <i id="upvote{{ $comment->id }}" style="cursor:not-allowed;" class="bi bi-hand-thumbs-up{{ $comment->ratings()->where('user_id', '=', Auth::id())->where('vote', '=', 'Upvote')->first() ? '-fill' : '' }} me-2" style="font-size: 1.5rem"></i>
            @endif
            <span id ="upvotes{{ $comment->id }}" class="user-select-none">{{ $comment->number_upvotes }}</span>
        </span>
        <span>
            @if(Auth::id() != $comment->author_id)
                <i id ="downvote{{ $comment->id }}" class="bi bi-hand-thumbs-down{{ $comment->ratings()->where('user_id', '=', Auth::id())->where('vote', '=', 'Downvote')->first() ? '-fill' : '' }} me-2" style="font-size: 1.5rem" onclick="addRatingComment({{ $comment->id }}, false);"></i>
            @else
                <i id ="downvote{{ $comment->id }}" style="cursor:not-allowed;" class="bi bi-hand-thumbs-down{{ $comment->ratings()->where('user_id', '=', Auth::id())->where('vote', '=', 'Downvote')->first() ? '-fill' : '' }} me-2" style="font-size: 1.5rem"></i>
            @endif
            <span id ="downvotes{{ $comment->id }}" class="user-select-none">{{ $comment->number_downvotes }}</span>
        </span>
    </div>
    <p>{{$comment->content}}</p>
    
    @php
        $files =  $comment->files()->get();
        $num_files = count($files);
    @endphp
    @if($num_files > 0)
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            {{ $num_files }} file{{ $num_files > 1 ? "s" : ""}} attached
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        @foreach($files as $file)
            <li><a class="dropdown-item" href="{{ route('getDownload', ['file_id' => $file->file_id]) }}">{{ $file->original_name }}</a></li>
        @endforeach
        </ul>
    @endif
</div>