<?php
session_start();
date_default_timezone_set("Europe/Paris");
require '../Models/Database.php';
require '../Models/Story.php';
require '../Models/User.php';
// Ternaires vérifiant comment l'utilisateur est loggé
$isConnectedViaSession = isset($_SESSION['userId']) && $_SESSION['userId'] != "" ? true : false;
$isConnectedViaCookie = isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" ? true : false;
$story = new Story();
// Récupération des valeurs des images en bdd
foreach ($story->detailsStory() as $key => $value) {
    // Les valeurs originales seront réutilisées pour supprimer le fichier du disque dur/serveur en cas de modif
    $originalPic1Value = $value[2];
    $originalPic2Value = $value[3];
    $originalPic3Value = $value[4];
    // Ces valeurs servent à l'affichage et seront envoyées en base de donnée
    $pic1Value = $value[2];
    $pic2Value = $value[3];
    $pic3Value = $value[4];
}
if (isset($_POST['submit'])) {
    // Vérifications titre
    if ($_POST['title'] == null) {
        $error['title'] = "La story doit obligatoirement avoir un titre";
    } else if (strlen($_POST['title']) < 3 || strlen($_POST['title']) > 50) {
        $error['title'] = "Le titre doit contenir entre trois (3) et cinquante (50) caractères";
    }
    // Vérifications de la story
    if ($_POST['story'] == null) {
        $error['story'] = "Racontez-nous un petit quelque chose, c'est le but du site !";
    } else if (strlen($_POST['story']) < 500) {
        $error['story'] = "La story doit contenir au moins 500 caractères, n'hésitez pas à détailler";
    }
    // Image obligatoire
    // Vérification si le user a changé l'image obligatoire
    if ($_FILES['picture1']['name'] == "") {
        $pic1Kept = true;
        // Vérification du poids de l'image
    } else if ($_FILES['picture1']['error'] == 1) {
        $error['picture1'] = "L'image ne doit pas excéder 5mo";
        // Vérification que le type de l'image est bien accepté
    } else if ($_FILES['picture1']['type'] != 'image/png' && $_FILES['picture1']['type'] != 'image/jpeg') {
        $error['picture1'] = "Le format de l'image n'est pas accepté. Formats acceptés : png ou jpg";
    }
    // Image 2 optionnelle
    // Vérification si le user a changé l'image 2
    if ($_POST['bufferInputPic2'] == "" && $_FILES['picture2']['name'] == "") {
        $pic2Kept = true;
        // Vérification si le user a supprimé l'image
    } else if ($_POST['bufferInputPic2'] == "deletedImage" && $_FILES['picture2']['name'] == "") {
        $pic2Deleted = true;
        // Vérification que le type de l'image est bien accepté
    } else if ($_FILES['picture2']['type'] != 'image/png' && $_FILES['picture2']['type'] != 'image/jpeg') {
        $error['picture2'] = "Le format de l'image n'est pas accepté. Formats acceptés : png ou jpg";
        // Vérification du poids de l'image
    } else if ($_FILES['picture2']['error'] == 1) {
        $error['picture2'] = "L'image ne doit pas excéder 5mo";
    }
    // Image 3 optionnelle
    // Vérification si le user a changé l'image 3
    if ($_POST['bufferInputPic3'] == "" && $_FILES['picture3']['name'] == "") {
        $pic3Kept = true;
        // Vérification si le user a supprimé l'image
    } else if ($_POST['bufferInputPic3'] == "deletedImage" && $_FILES['picture3']['name'] == "") {
        $pic3Deleted = true;
        // Vérification que le type de l'image est bien accepté
    } else if ($_FILES['picture3']['type'] != 'image/png' && $_FILES['picture3']['type'] != 'image/jpeg') {
        $error['picture3'] = "Le format de l'image n'est pas accepté. Formats acceptés : png ou jpg";
        // Vérification du poids de l'image
    } else if ($_FILES['picture3']['error'] == 1) {
        $error['picture3'] = "L'image ne doit pas excéder 5mo";
    }
    // Ternaires pour affichage des erreurs
    $titleValidationMessage = !isset($error['title']) ? "is-valid" : "is-invalid";
    $storyValidationMessage = !isset($error['story']) ? "is-valid" : "is-invalid";
    // S'il n'y a aucune erreur
    if (!isset($error)) {
        // Image obligatoire
        // Si le user veut changer son image obligatoire
        if (!isset($pic1Kept)) {
            // Récupération du chemin du dossier parent au dossier de travail en cours (pour envoyer les images)
            $uploadDir = dirname(getcwd()) . '/assets/userUploads/1_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_";
            // String a envoyer dans la base pour l'image obligatoire
            $dbStringPic = '/assets/userUploads/1_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_" . time() . $story->getFileExtension('picture1');
            // Renommage du fichier a uploader avec un timestamp pour éviter duplicata
            $uploadFile = $uploadDir . time() . $story->getFileExtension('picture1');
            // Envoi de l'image dans son dossier
            move_uploaded_file($_FILES['picture1']['tmp_name'], $uploadFile);
            // Attribution à la variable qui sera passée dans la méthode d'update
            $pic1Value = $dbStringPic;
            // Suppression du fichier sur le hdd/serveur
            unlink(dirname(getcwd()) . $originalPic1Value);
        }
        // Image 2
        if (!isset($pic2Kept) && !isset($pic2Deleted)) {
            // Si une image a été uploadée et qu'il n'y a pas d'erreur
            if ($_FILES['picture2']['error'] != 4 && !isset($error['picture2'])) {
                $uploadDir = dirname(getcwd()) . '/assets/userUploads/2_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_";
                $dbStringPic = '/assets/userUploads/2_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_" . time() . $story->getFileExtension('picture2');
                $uploadFile = $uploadDir . time() . $story->getFileExtension('picture2');
                move_uploaded_file($_FILES['picture2']['tmp_name'], $uploadFile);
                $pic2Value = $dbStringPic;
                unlink(dirname(getcwd()) . $originalPic2Value);
            } else {
                $pic2Value = "";
            }
        } else if (isset($pic2Deleted)) {
            $pic2Value = "";
            unlink(dirname(getcwd()) . $originalPic2Value);
        }
        // Image 3
        if (!isset($pic3Kept) && !isset($pic3Deleted)) {
            // Si une image a été uploadée et qu'il n'y a pas d'erreur
            if ($_FILES['picture3']['error'] != 4 && !isset($error['picture3'])) {
                $uploadDir = dirname(getcwd()) . '/assets/userUploads/3_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_";
                $dbStringPic = '/assets/userUploads/3_' . (isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId']) . "_" . time() . $story->getFileExtension('picture3');
                $uploadFile = $uploadDir . time() . $story->getFileExtension('picture3');
                move_uploaded_file($_FILES['picture3']['tmp_name'], $uploadFile);
                $pic3Value = $dbStringPic;
                unlink(dirname(getcwd()) . $originalPic3Value);
            } else {
                $pic3Value = "";
            }
        } else if (isset($pic3Deleted)) {
            $pic3Value = "";
            unlink(dirname(getcwd()) . $originalPic3Value);
        }
        $story->updateStory($pic1Value, $pic2Value, $pic3Value);
        header('Location: /Views/detailsStory.php?id=' . $_GET['id']);
        die;
    }
}
