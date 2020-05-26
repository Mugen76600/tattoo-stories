<?php
session_start();
date_default_timezone_set("Europe/Paris");
require '../Models/Database.php';
require '../Models/Story.php';
require '../Models/User.php';
// Envoi du formulaire de création de story
if (isset($_POST['submit'])) {
    $story = new Story();
    // Vérifications titre
    if ($_POST['title'] == null) {
        $error['title'] = "La story doit obligatoirement avoir un titre";
    } else if (strlen($_POST['title']) < 3 || strlen($_POST['title']) > 50) {
        $error['title'] = "Le titre doit contenir entre trois (3) et cinquante (50) caractères";
    }
    // Vérifications image obligatoire
    // Vérification qu'un fichier est bien uploadé
    if ($_FILES['picture1']['error'] == 4) {
        $error['picture1'] = "Cette image est obligatoire";
        // Vérification poids image
    } else if ($_FILES['picture1']['error'] == 1) {
        $error['picture1'] = "L'image ne doit pas excéder 5mo";
        // Vérification que le type de l'image est bien accepté
    } else if ($_FILES['picture1']['type'] != 'image/png' && $_FILES['picture1']['type'] != 'image/jpeg') {
        $error['picture1'] = "Le format de l'image n'est pas accepté. Formats acceptés : png ou jpg";
    }
    // Vérifications de la deuxième image s'il y a un upload
    if ($_FILES['picture2']['error'] != 4) {
        if ($_FILES['picture2']['type'] != 'image/png' && $_FILES['picture2']['type'] != 'image/jpeg') {
            $error['picture2'] = "Le format de l'image n'est pas accepté. Formats acceptés : png ou jpg";
        } else if ($_FILES['picture2']['error'] == 1) {
            $error['picture2'] = "L'image ne doit pas excéder 5mo";
        }
    }
    // Vérifications de la troisième image s'il y a un upload
    if ($_FILES['picture3']['error'] != 4) {
        if ($_FILES['picture3']['type'] != 'image/png' && $_FILES['picture3']['type'] != 'image/jpeg') {
            $error['picture3'] = "Le format de l'image n'est pas accepté. Formats acceptés : png ou jpg";
        } else if ($_FILES['picture3']['error'] == 1) {
            $error['picture3'] = "L'image ne doit pas excéder 5mo";
        }
    }
    // Vérifications de la story
    if ($_POST['story'] == null) {
        $error['story'] = "Racontez-nous un petit quelque chose, c'est le but du site !";
    } else if (strlen($_POST['story']) < 500) {
        $error['story'] = "La story doit contenir au moins 500 caractères, n'hésitez pas à détailler";
    }
    // Ternaires pour affichage des erreurs
    $titleValidationMessage = !isset($error['title']) ? "is-valid" : "is-invalid";
    $storyValidationMessage = !isset($error['story']) ? "is-valid" : "is-invalid";
    // Au cas où le formulaire ne contient pas d'erreur
    if (!isset($error)) {
        // Récupération du chemin du dossier parent au dossier de travail en cours (pour envoyer les images)
        $uploadDir = dirname(getcwd()) . '/assets/userUploads/1_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_";
        // String à envoyer dans la base pour l'image obligatoire
        $dbStringPic = '/assets/userUploads/1_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_" . time() . $story->getFileExtension('picture1');
        // Image obligatoire
        // Renommage du fichier à uploader avec l'id de l'input + l'id de l'utilisateur + le timestamp pour éviter duplicata
        $uploadFile = $uploadDir . time() . $story->getFileExtension('picture1');
        // Envoi de l'image dans son dossier
        move_uploaded_file($_FILES['picture1']['tmp_name'], $uploadFile);
        // Réattribution de la valeur de POST pour l'utilisation de la méthode plus loin
        $_POST['picture1'] = $dbStringPic;
        // Image 2
        // Vérification si une image a été uploadée
        if ($_FILES['picture2']['error'] != 4 && !isset($error['picture2'])) {
            $uploadDir = dirname(getcwd()) . '/assets/userUploads/2_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_";
            $dbStringPic = '/assets/userUploads/2_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_" . time() . $story->getFileExtension('picture2');
            $uploadFile = $uploadDir . time() . $story->getFileExtension('picture2');
            move_uploaded_file($_FILES['picture2']['tmp_name'], $uploadFile);
            $_POST['picture2'] = $dbStringPic;
        } else {
            $_POST['picture2'] = "";
        }
        // Image 3
        // Vérification si une image a été uploadée
        if ($_FILES['picture3']['error'] != 4 && !isset($error['picture3'])) {
            $uploadDir = dirname(getcwd()) . '/assets/userUploads/3_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_";
            $dbStringPic = '/assets/userUploads/3_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_" . time() . $story->getFileExtension('picture3');
            $uploadFile = $uploadDir . time() . $story->getFileExtension('picture3');
            move_uploaded_file($_FILES['picture3']['tmp_name'], $uploadFile);
            $_POST['picture3'] = $dbStringPic;
        } else {
            $_POST['picture3'] = "";
        }
        $story->addStory();
        header('Location: /index.php');
        die;
    }
}
