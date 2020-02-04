function insertAfter(referenceNode, newNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

function addActions() {
    let like_button = document.querySelectorAll('.is-like');
    like_button.forEach(function (elem) {
        if (elem.classList.contains('attached'))
            return;
        elem.classList.add('attached');
        elem.addEventListener('click', function () {
            if (!session_user)
                window.alert("Log in to Camagru for use this functionality.");
            else
                add_like(elem.id);
        });
    });

    let comment_button = document.querySelectorAll('.is-comment');
    let img_id_number;
    comment_button.forEach(function(elem) {
        if (elem.classList.contains('attached'))
            return;
        elem.classList.add('attached');
        elem.addEventListener("click", function _listener() {
            img_id_number = elem.id;
            img_id_number = parseInt(elem.id);
            if (!session_user)
                window.alert("Log in to Camagru for use this functionality.");
            else
            {
                let comment_id = elem.id;
                var element = document.getElementsByClassName(elem.id);
                var newElement = document.createElement('div');
                newElement.setAttribute('class', 'container');
                newElement.innerHTML =
                    '</br>\
                     <div style=\"text-align:center\" class=\"level\">\
                        <div class=\"field\">\
                            <input id=\"' + elem.id + '-submit\"'+ 'class=\"input\" type=\"text\" placeholder=\"Type your comment..\"' + 'required>\
                        </div>\
                        <button' + ' onclick=' + 'newComment(' + img_id_number + ') class=\"button is-info\">Comment</button>\
                     </div>';
                insertAfter(element[0], newElement);
                request_comments(parseInt(comment_id).toString());
            };
            elem.removeEventListener("click", _listener, true);
        }, true);
    });
};
addActions();


function add_like(img_id)
{
    let add_like =  document.getElementById(img_id);
    let hr = new XMLHttpRequest();
    let url = "/controller/controller.php?add_like";
    let vars = "img_id=" + img_id;

    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.setRequestHeader('cache-control', 'no-cache, must-revalidate, post-check=0, pre-check=0');
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            let number_like = add_like.getElementsByClassName(".badge").innerText;
            if (number_like) {
                number_like = number_like + 1;
            }
            else
                number_like = 1;
            add_like.innerHTML = '<i class=\"fas fa-thumbs-up\"></i> <span class=\"badge\">'+ number_like +'</span>';

        }
    };
    hr.send(vars);
    add_like.innerHTML = "<div id='loader'></div>";

}

function newComment(img_id) {
    // Select comment for place it after
    let ref = document.getElementsByClassName(img_id + "-c");
    // Select input to use comment placed in
    let input_comment = document.getElementById(img_id + "-c-submit").value;
    if (input_comment.length < 1) {
        alert("Please Fill Required Field");
        return;
    }
    var value = "img_id=" + img_id + "&comment=" + input_comment;
    var xhr = new XMLHttpRequest();
    var newElement = document.createElement('div');
    newElement.innerHTML =
        '<div class=\"' + img_id + '-loaded comment\"' + '><p><span id=\"username_comment\">' + username + '</span>' +
        '<span id=\"comment\">' + input_comment + '</span></p>' + '</div>';

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            insertAfter(ref[0], newElement);
            document.getElementById(img_id + "-c-submit").value = '';
        }
        else if (xhr.readyState < 4) {
        }
    };
    xhr.open("POST", "/controller/controller.php?new_comment", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(value);
}

window.onload = function loadMore(){
    let load_more = document.querySelector('#load_more');
    if (load_more) {
        load_more.addEventListener('click', function () {

            let is_load_more = document.getElementById('is_load_more');
            let last_img_id = document.getElementsByClassName('media');
            last_img_id = last_img_id[last_img_id.length - 1].className;
            last_img_id = last_img_id.match(/\d+/g).map(Number);
            var value = "last_img_id=" + last_img_id;
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                    insertImages(xhr.responseXML);
                } else if (xhr.readyState < 4) {
                    is_load_more.innerHTML = '<a id="load_more" class="button">Load more..</a><br><br>';
                    loadMore();

                }
            };
            xhr.open("POST", "/controller/controller.php?load_wall_images", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(value);
            is_load_more.innerHTML += '<div id="loader"></div>';
        });
    };
};

function insertImages(data) {
    let i = 0;
    let c = 0;
    let images = data.getElementsByTagName("item");
    let last_columns = document.getElementsByClassName('row columns');
        last_columns = last_columns[last_columns.length - 1];
    let row_columns = document.createElement('div');
        row_columns.setAttribute('class', 'row columns');

    while (i < images.length) {
        let badge_likes = '<span class="badge">' + images[i].getAttribute("likes") + '</span></span>';
        let badge_comments = '<span class="badge">' + images[i].getAttribute("comments") + '</span></span>';
        row_columns.innerHTML +=
            '<div id="wall_column" class="column is-one-third">\
                <div id="vignette" class="card large" style="box-shadow: 5px 13px 8px 2px;">\
                        <figure class="image is-4by3">\
                            <img id="' + images[i].getAttribute("img_id") + '-img" style="filter:' + images[i].getAttribute("img_filter") + '" src=' + images[i].getAttribute("img_link") + ' alt="Image">\
                        </figure>\
                    <div class="card-content">\
                        <div class="media ' +  images[i].getAttribute("img_id") + '-c">\
                            <div class="media-content">\
                                <p class="title is-4 no-padding">' + images[i].getAttribute("username") + '</p>\
                            </div>\
                            <div class="wall_icons">\
                                <span id="' + images[i].getAttribute("img_id") + '" class="icon is-medium is-right is-like">\
                                    <i class="fas fa-thumbs-up"></i>' + badge_likes +
                                    '<span id="' + images[i].getAttribute("img_id") + '-c" class="icon is-medium is-right is-comment">\
                                    <i class="fas fa-comment"></i>' + badge_comments +
                            '</div>\
                        </div>\
                    </div>\
                </div>\
            </div>\
            </div>';
        i++;
        c++;
        if (c == 3 || images.length <= 3 && c == images.length){
            insertAfter(last_columns, row_columns);
            addActions();
            last_columns = document.getElementsByClassName('row columns');
            last_columns = last_columns[last_columns.length - 1];
            row_columns = document.createElement('div');
            row_columns.setAttribute('class', 'row columns');
            c = 0;
        }
    }
}

