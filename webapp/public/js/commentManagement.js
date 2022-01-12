let filesData;
let content;

function addComment(eventId) {
    let url = '/api/event/' + eventId + '/comment';
    let form = document.getElementById('comment-form');
    if(form == null){
        return;
    }
    content = form.content.value;
    let files = form["files[]"].files;
    let request = new AJAXRequest(url, 'POST');
    request.setParam('content', content);

    if (files.length == 0) {
        request.send(null);
    } else loadFiles(request, files);
    /*
    r.send(function (xhr) {
        if(xhr.status == 200){
            // add comment
            console.log("create comment request");
        } else {
            console.log("there was an error");
        }
    });*/
}

function sendCommentRequest(request, filesData) {
    console.log(filesData);
    request.setParam('files', filesData);
    request.send(null);
}

function loadFile() {}

function loadFiles(request, files){
    filesData = [];
    for (let i = 0; i < files.length; ++i) {
        let fileReader = new FileReader();
        if (i == files.length - 1) {
            fileReader.onload = function(fileLoadedEvent){
                let textFromFileLoaded = fileLoadedEvent.target.result;
                filesData[i] = textFromFileLoaded;
                sendCommentRequest(request, filesData);
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