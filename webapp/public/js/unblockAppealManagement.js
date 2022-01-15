function sendUnblockAppeal() {
    let url = '/api/unblockAppeal';
    let form = document.getElementById('unblockAppealForm');
    if (form == null) {
        return;
    }

    let content = form.content.value;

    let request = new FormDataRequest(url);
    request.setParam('content', content);
    request.send(function (xhr) {
        if(xhr.status == 200){
            // TODO: Eliminar modal, alterar botão
        }
    });
}