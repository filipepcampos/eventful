function reloadComments(content) {
    let commentList = document.getElementById('commentsList');
    commentList.innerHTML = content;
}

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
    request.send(function (xhr) {
        if(xhr.status == 200){
            reloadComments(xhr.response);
        } else {
            console.log("Nope"); // TODO: What to do on error? nothing
        }
    });
}

function deleteComment(commentId) {
    let url = '/api/comment/' + commentId;
    let request = new URLEncodedRequest(url, 'DELETE');
    request.send(function (xhr) {
        if(xhr.status == 200) {
            console.log('commentRow' + commentId);
            document.getElementById('commentRow' + commentId).remove();
            let commentsList = document.getElementById('commentsList');
            if(commentsList.childElementCount == 0) {
                let msg = document.createElement('h3');
                msg.innerHTML = ' No comment has been created. ';
                commentsList.appendChild(msg);
            }
        } else {
            console.log("Nope"); // TODO: What to do on error?
        }
    });
}

function addRatingComment(commentId) {
    let url = '/api/comment/' + commentId + '/rating';
    let request = new URLEncodedRequest(url, 'POST');
    request.send(function (xhr) {
        if(xhr.status == 200) {
            // document.getElementById('upvotes').add();
        } else {
            console.log("Nope"); // TODO: What to do on error?
        }
    });
}