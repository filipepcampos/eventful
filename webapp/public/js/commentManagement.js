function addComment(eventId) {
    let url = '/api/event/' + eventId + '/comment';
    let form = document.getElementById('comment-form');
    if(form == null){
        return;
    }

    let content = form.content.value;
    let files = form["files[]"].files;

    let request = new FormDataRequest(url);
    request.setParam('content', content);
    for(let file of files) request.setParam('files[]', file);
    request.send(null); // TODO: update page with comment
}

function deleteComment(commentId) {
    // TODO
}