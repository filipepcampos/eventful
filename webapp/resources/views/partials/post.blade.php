<div class="row my-5" id="postRow{{$post->id}}">
    <p class="border postText" id="post{{$post->id}}" delta='{{$post->text}}'></p>
    <p>{{$post->creation_date}}</p>
    <div>
        @can('host', $event)
        <a class="btn btn-outline-primary" type="button" data-bs-toggle="modal" href="#postEditor" onclick="editPost('{{ $post->id }}')">Edit</a>
        <a class="btn btn-outline-danger" onclick="deletePost('{{ $post->id }}')">Delete</a>
        @endcan
    </div>
</div>