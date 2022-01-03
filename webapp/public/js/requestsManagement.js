function sendRequest(eventId) {
    let url = '/api/event/' + eventId + '/request';
    r = new AJAXRequest(url, 'POST');
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('request' + eventId).remove();
        }
    });
}

function accept(requestId) {
    let url = '/api/request/' + requestId + '/accept';
    r = new AJAXRequest(url, 'PUT');
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('request' + requestId).remove();
        }
    });
}

function reject(requestId) {
    let url = '/api/request/' + requestId + '/reject';
    r = new AJAXRequest(url, 'DELETE');
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('request' + requestId).remove();
        }
    });
}