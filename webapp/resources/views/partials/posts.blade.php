<h2 class="display-4">Posts</h2>

<div id="postList">
@foreach($posts as $post)
    @include('partials.post', ['post' => $post, 'event' => $event])
@endforeach
</div>