function sendRequest(eventId) {
    let url = '/api/event/' + eventId + '/request';
    r = new AJAXRequest(url, 'PUT');
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('request' + eventId).remove();
        }
    });
}