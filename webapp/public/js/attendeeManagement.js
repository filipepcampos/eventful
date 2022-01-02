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

function invite(eventId) {
    let url = '/api/event/' + eventId + '/invite';
    let input_box = document.getElementById('invitedUsername');
    let feedback = document.getElementById('inviteFeedback');
    if(input_box == null){
        return;
    }
    let username = input_box.value;
    if(username != null){
        r = new AJAXRequest(url, 'POST');
        r.setParam('username', username);
        r.send(function (xhr) {
            if(xhr.status == 200){
                validInviteFeedback(input_box,feedback);
            } else {
                invalidInviteFeedback(input_box,feedback);
            }
        });
    }
}

function validInviteFeedback(input_box, feedback){
    input_box.classList.remove('is-invalid');
    feedback.classList.remove('invalid-feedback');
    input_box.classList.add('is-valid');
    feedback.classList.add('valid-feedback');
    feedback.innerHTML = 'Invitation sent.';
}

function invalidInviteFeedback(input_box, feedback){
    input_box.classList.remove('is-valid');
    input_box.classList.add('is-invalid');
    feedback.classList.remove('valid-feedback');
    feedback.classList.add('invalid-feedback');
    feedback.innerHTML = 'Invitation not sent.';
}

function clearInviteFeedback(){
    let input_box = document.getElementById('invitedUsername');
    let feedback = document.getElementById('inviteFeedback');
    input_box.classList.remove('is-invalid');
    input_box.classList.remove('is-valid');
    feedback.classList.remove('invalid-feedback');
    feedback.classList.remove('valid-feedback');
    feedback.innerHTML = '';
}