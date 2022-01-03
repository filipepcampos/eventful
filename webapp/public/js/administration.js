function deleteUser(userId){
}

function blockUser(userId){
    let url = '/api/user/' + userId + '/block';
    console.log(url);
    r = new AJAXRequest(url, 'POST');
    let motive = 'sample motive';
    r.setParam('block_motive', motive);
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('userCard' + userId).classList.add('border-danger');
            let button = document.getElementById('blockButtonUser' + userId);
            button.innerHTML = 'Unblock';
            button.onclick = function () {unblockUser(userId)};
        }
    });
}

function unblockUser(userId){
    let url = '/api/user/' + userId + '/unblock';
    r = new AJAXRequest(url, 'POST');
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('userCard' + userId).classList.remove('border-danger');
            let button = document.getElementById('blockButtonUser' + userId);
            button.innerHTML = 'Block';
            button.onclick = function () {blockUser(userId)};
        }
    });
}