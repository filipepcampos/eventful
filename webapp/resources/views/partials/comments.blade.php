<h2 class="display-4">Comments</h2>
<form id="comment-form" class="form-group mb-3">
    <h1>Add comment:</h1>
    <textarea maxlength="200" type="textarea" name="content" class="form-control @if($errors->has('content')) is-invalid @endif" required></textarea>
    @if ($errors->has('content'))
        <div class="invalid-feedback d-block">
            {{ $errors->first('content') }}
        </div>
    @endif
    <input type="file" name="files[]" multiple>
</form>
@can('create', $event)
    <a type="button" class="btn btn-secondary" onclick="addComment('{{ $event->id }}');">Publish</a>
@endcan
@each('partials.comment', $comments, 'comment')