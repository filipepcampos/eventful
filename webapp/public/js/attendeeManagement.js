class AJAXRequest {
    constructor(url, type){
        this.url = url;
        this.type = type;

        let csrf_token = document.head.querySelector("[name~=csrf-token][content]").content;
        this.params = "_token="+csrf_token;
    }

    setParam(name,value){
        let str = name + "=" + value;
        this.params += '&'+str;
    }

    send(func){
        const xhr = new XMLHttpRequest();
        xhr.open(this.type, BASE_URL + this.url, true);
        if(func){
            xhr.onreadystatechange = function() {
                if(xhr.readyState == XMLHttpRequest.DONE){
                    func(xhr);
                }
            };
        }
        if(this.params != null){
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send(this.params);
        } else {
            xhr.send();
        }
    }
}

function kick(eventId,userId) {
    let url = '/api/event/' + eventId + '/kick';
    r = new AJAXRequest(url, 'POST');
    r.setParam('user_id',userId);
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('attendee' + userId).remove();
        }
    });
}