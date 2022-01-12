var quill = new Quill('#postCreationEditor', {
    modules: {
      toolbar: [
        [{ header: [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        ['blockquote', 'code-block'],
      ]
    },
    placeholder: 'Compose an epic...',
    theme: 'snow'  // or 'bubble'
  });

function createPost(eventId) {
    let url = '/api/event/' + eventId + '/post';
    let json = JSON.stringify(quill.getContents());
    r = new AJAXRequest(url, 'POST');
    r.setParam('text', json);
    r.send(function (xhr) {
        if(xhr.status == 200){
            console.log("Sent");
        } else {
            console.log("Nope");
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