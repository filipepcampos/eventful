function addComment(eventId) {
    let url = '/api/event/' + eventId + '/comment';
    let form = document.getElementById('comment-form');
    if(form == null){
        return;
    }

    let content = form.content.value;
    let files = form["files[]"].files;
/*
    let request = new AJAXRequest(url, 'POST');
    request.setParam('content', content);
    if (files.length > 0) request.setParam('files', files);

    request.send(null);
*/
    let xhr = new XMLHttpRequest();
    xhr.open('POST', BASE_URL + url, true);
    if(false) { // TODO
        xhr.onreadystatechange = function() {
            if(xhr.readyState == XMLHttpRequest.DONE){
                // update page with comment
            }
        };
    }
    xhr.setRequestHeader('X-CSRF-TOKEN', document.head.querySelector("[name~=csrf-token][content]").content);
    let formData = new FormData();
    formData.append('content', content);
    for(let file of files) {
        formData.append('files[]', file);
    }
    xhr.send(formData);
}