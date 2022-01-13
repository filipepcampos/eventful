// Send AJAX request to create post
function createPost(eventId) {
    let url = '/api/event/' + eventId + '/post';
    let contents = quill.getContents();
    let json = JSON.stringify(contents);
    r = new AJAXRequest(url, 'POST');
    r.setParam('text', json);
    r.send(function (xhr) {
        if(xhr.status == 200){
            createHTMLPost(json, xhr.response);
        } else {
            console.log("Nope"); // TODO: What to do on error?
        }
    });
}

// Send AJAX request to delete post
function deletePost(postId) {
    let url = '/api/post/' + postId;
    r = new AJAXRequest(url, 'DELETE');
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('postRow' + postId).remove();
        } else {
            console.log("Nope"); // TODO: What to do on error?
        }
    });
}

// Send AJAX request to edit post
function editPost(postId) {
    let url = '/api/post/' + postId;
    let newHTMLContent = quill.root.innerHTML;
    let contents = quill.getContents();
    let json = JSON.stringify(contents);
    r = new AJAXRequest(url, 'PUT');
    r.setParam('text', json);
    r.send(function (xhr) {
        if(xhr.status == 200){
            document.getElementById('post' + postId).innerHTML = newHTMLContent;
        } else {
            console.log("Nope"); // TODO: What to do on error?
        }
    });
}

function createHTMLPostButtons(id){
    let div = document.createElement('div');

    let editButton = document.createElement('a');
    editButton.classList.add('btn', 'btn-outline-primary');
    editButton.setAttribute('data-bs-toggle', 'modal');
    editButton.setAttribute('href', '#postEditor');
    editButton.setAttribute('type', 'button');
    editButton.onclick = () => openPostEditorForEdit(id);
    editButton.innerHTML = 'Edit';

    let deleteButton = document.createElement('a');
    deleteButton.classList.add('btn', 'btn-outline-danger');
    deleteButton.setAttribute('type', 'button');
    deleteButton.onclick = () => deletePost(id);
    deleteButton.innerHTML = 'Delete';

    let whitespace = document.createElement('span');
    whitespace.innerHTML = '&nbsp';

    div.appendChild(editButton);
    div.appendChild(whitespace);
    div.appendChild(deleteButton);

    return div;
}

// Create an HTML element for new post
function createHTMLPost(json, id){
    let postList = document.getElementById("postList");

    let row = document.createElement('div');
    row.classList.add('row', 'my-5', 'border');
    row.id = 'postRow' + id;

    let post = document.createElement('p');
    post.classList.add('postText');
    post.id = 'post' + id;
    post.setAttribute('delta', json);
    row.appendChild(post);

    let date = document.createElement('p');
    date.innerHTML = 'Now'; // TODO: Exhibit date
    row.appendChild(date);

    let buttonDiv = createHTMLPostButtons(id);
    row.appendChild(buttonDiv);

    postList.insertBefore(row, postList.firstChild);
    loadPost(post);
}

// Prepare editor for Create operation
function openPostEditorForCreate(eventId){
    let button = document.getElementById('postEditorSubmitButton');
    button.onclick = () => { createPost(eventId); };
    button.innerHTML = 'Create';
    clearPostEditor();
}

// Prepare editor for Update operation
function openPostEditorForEdit(postId){
    let button = document.getElementById('postEditorSubmitButton');
    button.onclick = () => { editPost(postId); };
    button.innerHTML = 'Update';
    let post = document.getElementById('post' + postId);
    let postDelta = post.getAttribute('delta');
    quill.setContents(JSON.parse(postDelta), 'api');
}

// Load a post content to HTML
function loadPost(post){
    let postDelta = post.getAttribute('delta');
    quill.setContents(JSON.parse(postDelta), 'api');
    post.innerHTML = quill.root.innerHTML;
}

// Load all posts to HTML
function loadPosts(){
    for(let post of document.getElementsByClassName("postText")){
        loadPost(post);
    }
}

// Clear Quill editor
function clearPostEditor(){
    quill.deleteText(0,quill.getLength());
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
    theme: 'snow'
  });

loadPosts();