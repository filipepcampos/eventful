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

class FormDataRequest {
    constructor(url) {
        this.url = url;
        this.formData = new FormData();
    }

    setParam(name, value) {
        this.formData.append(name, value);
    }

    send(func) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', BASE_URL + this.url, true);
        let csrf_token = document.head.querySelector("[name~=csrf-token][content]").content;
        xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);

        if(func){
            xhr.onreadystatechange = function() {
                if(xhr.readyState == XMLHttpRequest.DONE){
                    func(xhr);
                }
            };
        }
        xhr.send(this.formData);
    }
}