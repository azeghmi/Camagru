<?PHP
$path = $_SERVER['DOCUMENT_ROOT'];
require($path.'/mysql/mysql.php');
session_start();
ini_set('display_errors', 0);


function navbar(){
   require(getPath().'/view/navbar.php');
        }
function notifications(){
    require(getPath().'/view/notifications.php');
}
function login(){
   require(getPath().'/view/login.php');
        }
function wall(){
    require(getPath().'/view/wall.php');
}
function footer(){
    require(getPath().'/view/footer.php');
}
function take_picture(){
    require(getPath().'/view/take_picture.php');
}



// -- Delete image
if (isset($_GET['delete_image']) && isset($_SESSION['username']) && isset($_POST['img_id']))
    delete_image(strip_tags($_SESSION['username']), strip_tags($_POST['img_id']));

// -- Upload
if (isset($_GET['upload']) && isset($_SESSION['username']) && isset($_POST['data']) && isset($_POST['filename'])) {
    header("Content-Type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
    echo "<list>";
    $target_file = upload_file(strip_tags($_POST['data']));
    if (!$target_file)
        echo "<item src=\"ERROR\"/>";
    else
       echo "<item src=\"$target_file\"/>";
    echo "</list>";
}

// -- Load wall images
if (isset($_GET['load_wall_images']) && isset($_POST['last_img_id']))
{
    header("Content-Type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
    echo "<list>";
    $results = load_images_wall(strip_tags($_POST['last_img_id']));
    foreach ($results as $values)
        echo "<item username=\"" . $values['username'] . "\"" . " img_link=\"" . $values['img_link'] .  "\"" ." likes=\"" . $values['likes'] . "\"". " comments=\"" . $values['comments'] .  "\"" ." img_id=\"" . $values['id'] . "\"" . " img_filter=\"" . $values['filter'] . "\"/>";
    echo "</list>";
}

// -- Load wall comments
if (isset($_GET['load_comments']) && isset($_SESSION['username']) && isset($_POST['img_id']))
{
    header("Content-Type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
    echo "<list>";
    $results = load_comment(strip_tags($_POST['img_id']));
    foreach ($results as $values) {
        echo "<item comment=\"" . $values['comment'] . "\"" . " username=\"" . $values['username'] . "\"/>";
    }
    echo "</list>";
}

// -- Submit image
if (isset($_GET['submit_image']))
    submit_image(strip_tags($_SESSION['username']), strip_tags($_POST['data']), strip_tags($_POST['filter']));

// -- creat user
if (isset($_GET["create"]) && isset($_POST["submit"]) && isset($_POST["username"]) && isset($_POST["pwd_1"]) && isset($_POST["pwd_2"])
    && isset($_POST["mail_1"]))
{
    check_data(strip_tags($_POST['username']), strip_tags($_POST['pwd_1']), strip_tags($_POST['pwd_2']), strip_tags($_POST['mail_1']));
    if (!isset($_SESSION['password_not_strong']) && !isset($_SESSION['mail_error']))
        userCreate(strip_tags(trim($_POST['username'])), $_POST['pwd_1'], strip_tags(trim($_POST['mail_1'])));
    else
        header('Location: ./index.php?signup');
}

// -- connect user
if (isset($_GET["connect"]) && isset($_POST["submit"]) && isset($_POST["username"]) && isset($_POST["pwd"]))
{
    userConnect(strip_tags(trim($_POST['username'])), (strip_tags($_POST['pwd'])));
    exit();
    }

// -- Forgot password - Change password
if(isset($_GET['change_password_by_forgot']) && isset($_GET['username']) && isset($_GET['password_key'])
    && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['submit']))
    change_password_by_forgot(strip_tags($_GET['username']), strip_tags($_GET['password_key']), strip_tags($_POST['password']), strip_tags($_POST['password_confirm']));


// -- Mail password send link
if (isset($_GET['mail_password']) && isset($_POST['mail']) && isset($_POST['username']))
    mail_password(strip_tags($_POST['mail']), strip_tags($_POST['username']));

// -- Set comment notifications
if (isset($_GET['notifComments']) && isset($_SESSION['username']) && isset($_POST['checked']))
    notifComment(strip_tags($_SESSION['username']), strip_tags($_POST['checked']));

// -- New Comment
if (isset($_GET['new_comment']) && isset($_SESSION['username']) && isset($_POST['img_id']) && isset($_POST['comment'])){
    new_comment(strip_tags($_SESSION['username']), strip_tags($_POST['img_id']), strip_tags($_POST['comment']));
}

// -- Mail confirmation
if (isset($_GET['username']) && isset($_GET['valid_key']))
    mail_confirmation(strip_tags($_GET['username']), strip_tags($_GET['valid_key']));

// -- Mail password confirmation for change password
if (isset($_GET['mail_password_confirmation']) && isset($_GET['username']) && isset($_GET['password_key']))
    mail_password_confirmation(strip_tags($_GET['username']), strip_tags($_GET['password_key']));


// -- Add like
if (isset($_GET['add_like']) && isset($_SESSION['username']) && isset($_POST['img_id']))
    add_like(strip_tags($_POST['img_id']), strip_tags($_SESSION['username']));


// -- change password
 if (isset($_GET["change_password"]) && isset($_POST["submit"]) && isset($_POST["pwd_old"]) && isset($_POST["new_pwd_2"]) && isset($_POST["new_pwd_1"]))
 {
     check_data('', strip_tags($_POST['new_pwd_1']), strip_tags($_POST['new_pwd_2']), '');
     if (!isset($_SESSION['password_not_strong']))
         user_change_password(strip_tags($_SESSION['username']), strip_tags($_POST['pwd_old']), strip_tags($_POST['new_pwd_1']));
    else {
        header('Location: ./index.php?profil');
    }
 }

 // -- change username
 if (isset($_GET["change_username"]) && isset($_POST["submit"]) && isset($_POST["old_username"]) && isset($_POST["new_username"]) && isset($_POST["conf_new_username"]))
 {
    if($_POST["new_username"] === $_POST["conf_new_username"])
       user_change_name(strip_tags($_SESSION['username']), strip_tags($_POST['new_username']));
    else
        header('Location: ./index.php?profil');
 }

// // -- change mail
if (isset($_GET["Submit_email"]) && isset($_POST["submit"]) && isset($_POST["old_mail"]) && isset($_POST["new_mail"]) && isset($_POST["conf_new_mail"]))
    {
      if($_POST["new_mail"] === $_POST["conf_new_mail"])
        user_change_mail(strip_tags($_SESSION["username"]), strip_tags($_POST["old_mail"]), strip_tags($_POST["new_mail"]));
        else
            header('location: ./index.php/profil');
    }
?>
