<h2 class="display-4">Comments</h2>
<form class="form-group mb-3" method="POST" action="{{ route('createComment') }}" enctype="multipart/form-data">
    <h1>Add comment:</h1>
    <textarea id="content" maxlength="8192" type="textarea" name="content" class="form-control @if($errors->has('content')) is-invalid @endif" required></textarea>
    @if ($errors->has('content'))
        <div class="invalid-feedback d-block">
            {{ $errors->first('content') }}
        </div>
    @endif
    <input type="file" name="files" multiple>
    <button type="submit" class="btn btn-secondary">Publish</button>
</form>
@each('partials.comment', $comments, 'comment')