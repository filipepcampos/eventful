let filesData;
let content;
/*
function addComment(eventId) {
    console.log("here");
    let url = '/api/event/' + eventId + '/comment';
    let form = document.getElementById('comment-form');
    if(form == null){
        return;
    }
    content = form.content.value;
    let files = form["files[]"].files;
    console.log(files);
    const xhr = new XMLHttpRequest();
    // https://stackoverflow.com/questions/36475737/javascript-xhr-file-upload-without-jquery
    if (files.length == 0) {
        let formData = new FormData();
        formData.append("content", content);
        xhr.open('POST', BASE_URL + url);
        xhr.send(formData);
    } else loadFiles(url, files, xhr);
    //xhr.setRequestHeader('Content-type', "multipart/form-data");
    /*r = new AJAXRequest(url, 'POST', );
    r.setParam('content', content);
    r.setParam('files', files);
    r.send(function (xhr) {
        if(xhr.status == 200){
            // add comment
            console.log("create comment request");
        } else {
            console.log("there was an error");
        }
    });
}*/

function addComment(eventId) {
    let url = '/api/event/' + eventId + '/comment';
    let form = document.getElementById('comment-form');
    if(form == null){
        return;
    }
    content = form.content.value;
    let files = form["files[]"].files;
    const xhr = new XMLHttpRequest();
    // https://stackoverflow.com/questions/36475737/javascript-xhr-file-upload-without-jquery
    if (files.length == 0) {
        let formData = new FormData();
        formData.append("content", content);
        xhr.open('POST', BASE_URL + url);
        xhr.send(formData);
    } else loadFiles(url, files, xhr);
    //xhr.setRequestHeader('Content-type', "multipart/form-data");
    /*r = new AJAXRequest(url, 'POST', );
    r.setParam('content', content);
    r.setParam('files', files);
    r.send(function (xhr) {
        if(xhr.status == 200){
            // add comment
            console.log("create comment request");
        } else {
            console.log("there was an error");
        }
    });*/
}

function sendCommentRequest(url, xhr, filesData) {
    let formData = new FormData();
    formData.append("content", content);
    formData.append("content", filesData);
    xhr.open('POST', BASE_URL + url);
    xhr.send(formData);
}

function loadFile() {}

function loadFiles(url, files, xhr){
    filesData = [];
    for (let i = 0; i < files.length; ++i) {
        let fileReader = new FileReader();
        if (i == files.length - 1) {
            fileReader.onload = function(fileLoadedEvent){
                let textFromFileLoaded = fileLoadedEvent.target.result;
                filesData[i] = textFromFileLoaded;
                sendCommentRequest(url, xhr, filesData);
            };
        } else {
            fileReader.onload = function(fileLoadedEvent){
                let textFromFileLoaded = fileLoadedEvent.target.result;
                filesData[i] = textFromFileLoaded;
            };
        }
        fileReader.readAsText(files[i], "UTF-8");
    }
}