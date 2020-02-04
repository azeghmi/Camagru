
<html>
<head>
        <link rel="icon" type="image/png" href="/app/img/camagru.png" />
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/bulma.css">
        <script src="https://kit.fontawesome.com/fd15cbdc52.js" crossorigin="anonymous"></script>
        <meta name="viewport"             content="width=device-width, initial-scale=1.0" />

        <title>Camagru</title>
</head>

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="img-responsive" href="/index.php?wall">
          <img  src="./app/img/camagru.png">
        </a>
    </div>
        <div class="navbar-end">
          <div class="navbar-item">
            <div class="buttons">
            <?php
            if (isset($_SESSION['username']) && !isset($_GET['logout'])){
              echo'<a href="/index.php?wall" class="button is-primary is-large"> Wall </a>';
              echo'<a href="/index.php?take_picture" class="button is-primary is-large"> Take picture  </a>';
              echo'<a href="/index.php?profil" class="button is-primary is-large"> Profil </a>';
              echo'<a href="/index.php?logout" class="button is-danger is-large"> <strong>Logout</strong> </a>';
            }
            else
            {
                echo'<a href="/index.php?wall" class="button is-primary is-large"> Wall </a>';
            echo'<a href="/index.php?signup" class="button is-primary is-large"> <strong>Sign up</strong> </a>';
            echo'<a href="/index.php?login" class="button is-light is-large"> Log in </a>';

            }
                ?>
            </div>
          </div>
        </div>
</nav>