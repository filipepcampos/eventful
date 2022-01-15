function deleteUser(userId){
}

function blockUser(userId){
    let url = '/api/user/' + userId + '/block';
    console.log(url);
    r = new URLEncodedRequest(url, 'PUT');
    let motive = 'sample motive';
    r.setParam('block_motive', motive);
    r.send(function (xhr) {
        if(xhr.status == 200){
            let card = document.getElementById('userCard' + userId)
            card.classList.add('border-secondary');
            card.classList.add('border-1');
            let button = document.getElementById('blockButtonUser' + userId);
            button.classList.add('btn-secondary');
            button.classList.remove('btn-outline-secondary');
            button.innerHTML = 'Unblock';
            button.onclick = function () {unblockUser(userId)};
        }
    });
}

function unblockUser(userId){
    let url = '/api/user/' + userId + '/unblock';
    r = new URLEncodedRequest(url, 'PUT');
    r.send(function (xhr) {
        if(xhr.status == 200){
            let card = document.getElementById('userCard' + userId)
            card.classList.remove('border-secondary');
            card.classList.remove('border-1');
            let button = document.getElementById('blockButtonUser' + userId);
            button.innerHTML = 'Block';
            button.classList.remove('btn-secondary');
            button.classList.add('btn-outline-secondary');
            button.onclick = function () {blockUser(userId)};
        }
    });
}