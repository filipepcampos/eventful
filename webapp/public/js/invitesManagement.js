function accept(inviteId) {
    let url = '/api/invite/' + inviteId + '/accept';
    r = new AJAXRequest(url, 'PUT');
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('invite' + inviteId).remove();
        }
    });
}

function reject(inviteId) {
    let url = '/api/invite/' + inviteId + '/reject';
    r = new AJAXRequest(url, 'DELETE');
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('invite' + inviteId).remove();
        }
    });
}