<?php
session_start();
date_default_timezone_set("Europe/Paris");
require '../Models/Database.php';
require '../Models/Story.php';
require '../Models/User.php';
// A la déconnexion de l'utilisateur, détruit ses cookies de log ou sa session, puis redirige vers l'accueil
if (isset($_POST['disconnect'])) {
    if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] != "") {
        session_destroy();
        header('Location: /index.php');
        die;
    } else if (isset($_COOKIE['userLogin'])) {
        setcookie('userLogin', "", time() - 1000, '/');
        setcookie('userMail', "", time() - 1000, '/');
        setcookie('userLastname', "", time() - 1000, '/');
        setcookie('userFirstname', "", time() - 1000, '/');
        setcookie('userId', "", time() - 1000, '/');
        header('Location: /index.php');
        die;
    }
}
// Instanciation d'un objet de classe Story pour afficher les stories de l'utilisateur
$story = new Story();
if (isset($_POST['deleteStory'])) {
    $story->deleteStory();
    header('Location: ' . $_SERVER['PHP_SELF']);
    die;
}
