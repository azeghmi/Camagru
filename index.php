<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require($path .'/controller/controller.php');
session_start();
navbar();
notifications();
login();
if (isset($_GET['logout']))
    Logout();
if (isset($_GET['take_picture']))
    take_picture();
if (!isset($_GET['take_picture']) && !isset($_GET['login']) && !isset($_GET['signup'])
    && !isset($_GET['profil']))
    wall();
footer();