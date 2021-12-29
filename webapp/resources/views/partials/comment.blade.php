<div class="row">
    <h1>{{$comment->author()->get()->first()->username}}</h1>
    <p>{{$comment->creation_date}}</p>
    <p>{{$comment->content}}</p>
</div>