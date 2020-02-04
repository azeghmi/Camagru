<?php
if (isset($_SESSION['username']))
    $results = get_lasts_images($_SESSION['username']);
else{
    header('Location: /index.php');
    exit();
}

?>

<div class="hero animate" onload="captureCam();">
    <div class="hero-body">
        <div style="padding-top: 0em;" class="container has-text-centered">
            <h1 class ="title is-1"id="title_top" >Take your picture !</h1>
        </div>
    </div>
</div>
<nav style=" min-height:50%; "class="columns is-centered">
    <div class="hero level-left">
            <div id="screenshot" class="montage" style="text-align:center;">
                <div id="video">
                    <video autoplay></video></br></br>
                    <div style="width: 100%;"class="select">
                        <select  id="photo-filter" style="width: 100%;">
                            <option value="" selected disabled hidden>Choose a filter</option>
                            <option value="none">No filter</option>
                            <option value="grayscale(100%">Grayscale</option>
                            <option value="sepia(100%)">Sepia</option>
                            <option value="invert(100%)">Invert</option>
                            <option value="hue-rotate(90deg)">Hue</option>
                            <option value="blur(10px)">Blur</option>
                            <option value="contrast(200%)">Contrast</option>
                        </select>
                    </div>
                    </br></br>
                    <button class="button is-primary is-left" style="width: 100%;"id="screenshot-button">Take screenshot</button>
 
                    </br></br><canvas style="display:none" id="canvas"></canvas>
                    <div class="images">
                        <div id="9" class="filter filter1" style="width: 150px; height: 150px; background-size:contain;background-image: url('./app/img/montage/min/min_lounys_1.jpg');"></div>
                        <div id="1" class="filter filter1" style="width: 150px; height: 150px; background-size:contain;background-image: url('./app/img/montage/min/min_lounys_2.jpg');"></div>
                        <div id="3" class="filter filter3" style="width: 150px; height: 150px; background-size:contain;background-image: url('./app/img/montage/min/min_pingouin_3.jpg');"></div>
                        <div id="4" class="filter filter4" style="width: 150px; height: 150px; background-size:contain;background-image: url('./app/img/montage/min/min_pingouin_4.jpg');"></div>
                        <div id="5" class="filter filter5" style="width: 150px; height: 150px; background-size:contain;background-image: url('./app/img/montage/min/min_pingouin_5.jpg');"></div>
                        <div id="6" class="filter filter6" style="width: 150px; height: 150px; background-size:contain;background-image: url('./app/img/montage/min/min_pingouin_6.jpg');"></div>
                        <div id="7" class="filter filter7" style="width: 150px; height: 150px; background-size:contain;background-image: url('./app/img/montage/min/min_pingouin_7.jpg');"></div>
                    </div>
                    <div id="status"></div>
                    <button class="button is-primary" style="width: 100%;"id="login_button submit-image">Submit image</button>
                    </div>
                       <div class="upload">
                    <input style="display: none" type="file" accept="image/jpeg, image/png, image/jpg" id="upload-file"/>
                    <button class="button is-primary" id="choose-button">Select image to upload</button>
            </div>
            </div></div>
    <!-- style="display:inline-block"  -->
    <div style="display:inline-block" class="level-right montage-right">
    <!-- Right side -->
        </br>
            <div id="js-container lasts_images">
                <h1 style="font-size: 0.8em;"class="subtitle">After uploading your image, please reload the page if you want to delete one.</h1>
                </br>
                <div id="lasts_images"></br>
                    <?php
                    $i = 0;
                    foreach ($results as $value){
                        $img_filter = $value['img_filter'];
                        $img_link = $value['img_link'];
                        $img_id = $value['id'];
                        if($i == 2) {
                            echo "</div>";
                            $i = 0;
                        }
                        if ($i == 0) {
                            echo "<div class=\"columns\">";
                        }
                        echo "<div id=\"$img_id-img_id\" class=\"column\">
                         <a id=\"$img_id\" class=\"button_close\"><i class=\"fas fa-times\"></i></a>
                                <figure class=\"image is-4by3 close\">
                                     <img style=\"filter:$img_filter;margin-top: 20;\" src=\"$img_link\">
                                </figure></br>
                              </div>";
                        $i++;
                    }
                    ?>
                </div>
            </div>
    </div>
</nav>


<script src="./js/webcam.js"></script>
