let image_video = new Image();
const video = document.querySelector('#screenshot video');
document.getElementById("login_button submit-image").disabled = true;
document.querySelector("#screenshot-button").disabled = true;


function hasGetUserMedia() {
    return (navigator.mediaDevices &&
        navigator.mediaDevices.getUserMedia);
}

if (hasGetUserMedia()) {
    const hdConstraints = {
        video: {width: {min: 1280}, height: {min: 720}}
    };
    navigator.mediaDevices.getUserMedia(hdConstraints).then((stream) => {video.srcObject = stream});
    window.onload = function() {
        navigator.mediaDevices.getUserMedia({video:true,audio:false})
            .then(function(stream){
                video.srcObject = stream;
                video.setAttribute('playsinline', '');
                video.play();
                document.querySelector("#screenshot-button").disabled = false;
            })
            .catch(function(err){
                console.log(`Error: ${err}`);
            });
    };
}
else {
    alert('getUserMedia() is not supported by your browser');
}

;(function() {
    document.getElementById("login_button submit-image").disabled = true;
    let submitButton = document.getElementById('login_button submit-image');
    const canvas = document.getElementById('canvas');
    let photoFilter = document.getElementById('photo-filter');
    let filter = "none";
    let img_div = document.querySelector('.images');
        img_div = img_div.querySelectorAll('.filter');

    photoFilter.addEventListener('change', function (e) {
        filter = e.target.value;
        video.style.filter = filter;
        e.preventDefault();
    });
    if(submitButton) {
        submitButton.addEventListener('click', function () {
            submitImage(filter);
    });
}
    document.querySelector("#screenshot-button").onclick = function () {
        document.getElementById("login_button submit-image").disabled = true;
        document.getElementById("canvas").style.display = "block";
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.style.filter = filter;
        canvas.getContext('2d').drawImage(video, 0, 0);
        image_video.src = canvas.toDataURL('image/png');
    };
    img_div.forEach(function(elem) {
        elem.addEventListener('click', function() {
            style = elem.currentStyle || window.getComputedStyle(elem, false);
            image_selected = style.backgroundImage.slice(4, -1).replace(/"/g, "");
            image_name = image_selected.split("/");
            image_name = image_name.pop().replace("min", "alpha");
            image_name = image_name.replace("jpg", "png");
        });
    });

    canvas.addEventListener('click', function(e){
        document.getElementById("login_button submit-image").disabled = false;
        let canvasid = document.getElementById("canvas");
        let save_old_canvas = canvasid;
        let context = save_old_canvas.getContext('2d');
        const rect = canvasid.getBoundingClientRect();
        dx = e.clientX - rect.left;
        dy = e.clientY - rect.top;
        var image = new Image();
        image.onload = function() {
            context.drawImage(image_video, 0,0);
            context.drawImage(image, dx - (image.width / 2), dy - (image.height / 2));
        };
    image.src = "/app/img/montage/alpha/"+image_name;
    });

    document.querySelector('#choose-button').addEventListener('click', function() {
        document.querySelector('#upload-file').click();
    });

    document.querySelector('#upload-file').addEventListener('change', function() {
        var file = this.files[0];

        // Allowed types
        var mime_types = [ 'image/jpeg', 'image/png', 'image/jpg'];

        // Validate MIME type
        if(mime_types.indexOf(file.type) == -1) {
            alert('Error : Incorrect file type');
            return;
        }
        if(file.size > 8*1024*1024) {
            alert('Error : Exceeded size 8MB');
            return;
        }
        alert('You have chosen the file ' + file.name);
        uploadImage(file, filter);
    });

    function uploadImage(){
        var image;
        var file = document.querySelector('#upload-file');
        var reader = new FileReader();
        var request = new XMLHttpRequest();

        request.open("POST", '/controller/controller.php?upload', true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.setRequestHeader('cache-control', 'no-cache, must-revalidate, post-check=0, pre-check=0');
        reader.onload = function(e) {
            image = e.target.result;
            var data = "filename=" + file.files[0].name + "&" + "data=" + image;
            request.addEventListener('load', function(e) {
                let new_image = request.responseXML;
                new_image = new_image.getElementsByTagName('item');
                if (new_image[0].getAttribute('src') == "ERROR")
                    alert("Uploaded file is not valid");
                else
                    add_image_canvas(new_image[0].getAttribute('src'));
            });
            let ref_upload = document.getElementsByClassName('upload');

            let progress_bar = document.createElement('div');
            progress_bar.setAttribute('class', 'progress_bar');
            progress_bar.innerHTML = '</br><progress class=\"progress is-info\" max=\"100\"></progress>';
            if (document.getElementsByClassName('progress_bar')[0])
                document.getElementsByClassName('progress_bar')[0].innerHTML = "";
            insertAfter(ref_upload[0], progress_bar);
            request.upload.addEventListener('progress', function(e) {
                var percent_complete = (e.loaded / e.total)*100;
                var percent = percent_complete.toString();
                document.getElementsByClassName('progress is-info')[0].setAttribute("value", percent);
            });

            request.send(data);
        };
        reader.readAsDataURL(file.files[0]);

    }

    let close = document.querySelectorAll('.button_close');
    close.forEach(function(elem){
        elem.addEventListener('click', function _listener(){
            let id = elem.id;
            let img = document.getElementById(id + "-img_id");

            img.style.display = "none";
            elem.style.display = "none";

            var value = "img_id=" + id;
            var xhr   = new XMLHttpRequest();
            xhr.open("POST", "/controller/controller.php?delete_image", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(value);

        });
    });
    function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }


    function add_image_canvas(src, filter){
        const canvas = document.getElementById('canvas');
        document.getElementById("canvas").style.display = "block";
        document.getElementById("login_button submit-image").disabled = false;
        var image = new Image();
        image.src = src;
        image.onload = function(){
            canvas.width = image.width;
            canvas.height = image.height;
            canvas.style.filter = filter;
            canvas.getContext('2d').drawImage(image, 0, 0);
            image_video.src = canvas.toDataURL('image/png');
        }
    }
})();

function submitImage(filter) {
    var canvas = document.getElementsByTagName("CANVAS")[0];
    document.getElementById("login_button submit-image").disabled = true;
    document.getElementById("screenshot-button").disabled = true;

    if (canvas) {
        var hr = new XMLHttpRequest();
        var vars = "data=" + canvas.toDataURL('image/png') + "&" + "filter=" + filter;
        hr.onreadystatechange = function () {
            if (hr.readyState == 4 && (hr.status == 200 || hr.status == 0)) {
                document.getElementById("status").innerHTML = "<p id='notification_upload'>Image successfully added !</p>";
                document.getElementById("screenshot-button").disabled = false;
                console.log(filter);
                add_image(canvas.toDataURL('image/png'), filter);
                console.log("send....");
            } else if (hr.readyState < 4) {
                console.log("wait....");
            }
        };
        hr.open("POST", "/controller/controller.php?submit_image", true);
        hr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        hr.send(vars);
        document.getElementById("status").innerHTML = "<div style='margin-bottom:10px;' id='loader'></div>";
    }
}


function add_image(data, filter) {
    let ref = document.getElementById("lasts_images");

    let newFigure = document.createElement('figure');
        newFigure.setAttribute('class', 'image is-4by3 close');
    let newImage = document.createElement('img')
        newImage.setAttribute("style", "filter:" + filter);
        newImage.setAttribute("src", data);
        newFigure.appendChild(newImage);
        ref.appendChild(newFigure);
}
