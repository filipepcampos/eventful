<h2 class="display-4">Posts</h2>
@can('createPost', $event)
<a class="btn btn-secondary mb-2" type="button" data-bs-toggle="modal" href="#postEditor" onclick="openPostEditorForCreate('{{ $event->id }}')">Create Post</a>
@endcan

<div id="postList">
@foreach($posts as $post)
    @include('partials.post', ['post' => $post, 'event' => $event])
@endforeach
</div>