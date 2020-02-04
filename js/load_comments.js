let save_img_id = null;
let counter_comment;

function request_comments(img_id) {
    let comment =  document.getElementById(img_id + "-c");
    var value = "img_id=" + img_id;
    var xhr   = new XMLHttpRequest();
    let newElement = document.createElement('div');
    newElement.setAttribute('id', 'loader');
    insertAfter(comment, newElement);

    xhr.onreadystatechange = function() {
        let loader =  document.getElementById("loader");
        loader.style.display = "none";


        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {

            read_comment(xhr.responseXML, img_id);
            loader.style.display = "none";
            loader.parentNode.removeChild(loader);
            comment.style.display = "inline-flex";
        }
        else if (xhr.readyState < 4) {
            loader.style.display = "inline-block";
            comment.style.display = "none";
        }
    };

    xhr.open("POST", "/controller/controller.php?load_comments", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(value);
}

function read_comment(data, img_id) {

    let i;

    if (save_img_id == null)
    {
        save_img_id = img_id;
        counter_comment = 2;
        i = 0;
    }

    else
    {

        if (save_img_id != img_id)
        {
            save_img_id = img_id;
            counter_comment = 0;
        }
        i = counter_comment;
        counter_comment = counter_comment + 2;
    }

    let comment = data.getElementsByTagName("item");
    let ref = document.getElementsByClassName(img_id + "-c");
    let check_number_comments = document.getElementsByClassName(img_id + "-loaded");

    while (i < comment.length && i < counter_comment && check_number_comments.length < comment.length)
    {
        let newElement = document.createElement('div');
        newElement.innerHTML =
            '<div class=\"' + img_id + '-loaded comment\">' +
            '<p>' +
            '<span id=\"username_comment\">'+  comment[i].getAttribute("username") + '</span>' +
            ':'  +
            '<span id=\"comment\">' + comment[i].getAttribute("comment") + '</span>' +
            '</p>' +
            '</div>';
        insertAfter(ref[0], newElement);
        i++;
    }

    let ref_last_comment = document.getElementsByClassName(img_id + "-loaded");
    let check_load_more = document.getElementsByClassName(img_id + "-load_comment");

    if (ref_last_comment.length < comment.length)
    {
        let load_comment = document.createElement('div');
        if (check_load_more == null || check_load_more.length < 1 )
        {
            load_comment.innerHTML =
                '<div class="' + img_id + '-load_comment load_more">' +
                '<p>Load more..</p>' +
                '</div>';
            insertAfter(ref_last_comment[ref_last_comment.length - 1], load_comment);
    
            load_comment.addEventListener('click', function(){request_comments(img_id)});
        }
    }
}