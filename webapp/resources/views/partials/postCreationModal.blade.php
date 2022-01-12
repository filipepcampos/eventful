<!-- Modal -->
<div class="modal fade" id="postCreation" tabindex="-1" role="dialog" aria-labelledby="postCreationLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content h-100">
        <div class="modal-header">
            <h5 class="modal-title" id="postCreationLabel">Create Post</h5>
        </div>
        <div class="modal-body">
            <div id="postCreationEditor">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="createPost('{{ $event_id }}')">Post</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>