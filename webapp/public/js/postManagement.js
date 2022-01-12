function createPost(eventId) {
    let url = '/api/event/' + eventId + '/post';
    let contents = quill.getContents();
    let json = JSON.stringify(contents);
    r = new AJAXRequest(url, 'POST');
    r.setParam('text', json);
    r.send(function (xhr) {
        if(xhr.status == 200){
            createHTMLpost(json);
        } else {
            console.log("Nope"); // TODO: What to do on error?
        }
    });
}

function deletePost(postId) {
    let url = '/api/post/' + postId;
    r = new AJAXRequest(url, 'DELETE');
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('postRow' + postId).remove();
        } else {
            console.log("Nope"); // TODO: What to do on error?
        }
    })
}

function editPost(postId) {
    let post = document.getElementById('post' + postId);
    let postDelta = post.getAttribute('delta');
    quill.setContents(JSON.parse(postDelta), 'api');
}

function createHTMLpost(json){
    let postList = document.getElementById("postList");

    let row = document.createElement('div');
    row.classList.add('row');

    let post = document.createElement('p');
    post.classList.add("border");
    post.classList.add("postText");
    post.setAttribute('delta', json);
    row.appendChild(post);

    let date = document.createElement('p');
    date.innerHTML = 'Now'; // TODO: Exhibit date
    row.appendChild(date);

    postList.insertBefore(row, postList.firstChild);
    loadPost(post);
}

let quills = new Map();

function loadPost(post){
    let postDelta = post.getAttribute('delta');
    let q = new Quill(post, {
        readOnly: true,
        theme: 'bubble'
      });
    q.setContents(JSON.parse(postDelta), 'api');
}

function loadPosts(){
    for(let post of document.getElementsByClassName("postText")){
        loadPost(post);
    }
}

var quill = new Quill('#postEditorQuill', {
    modules: {
      toolbar: [
        [{ header: [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        ['blockquote', 'code-block'],
      ]
    },
    placeholder: 'Compose your post...',
    theme: 'snow'  // or 'bubble'
  });

loadPosts();