<?php
session_start();
date_default_timezone_set("Europe/Paris");
require '../Models/Database.php';
require '../Models/Story.php';
require '../Models/User.php';
$story = new Story();
// Au cas où une recherche est effectuée avec un input vide, la page s'actualise
if (isset($_GET['search'])) {
    if ($_GET['query'] == null) {
        header('Location:' . $_SERVER['PHP_SELF']);
        die;
    }
}
