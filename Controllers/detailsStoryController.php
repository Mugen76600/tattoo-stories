<?php
session_start();
date_default_timezone_set("Europe/Paris");
require '../Models/Database.php';
require '../Models/Story.php';
require '../Models/User.php';
require '../Models/Comment.php';
$story = new Story();
$comment = new Comment();
// Ternaires vérifiant comment l'utilisateur est loggé
$isConnectedViaSession = isset($_SESSION['userId']) && $_SESSION['userId'] != "" ? true : false;
$isConnectedViaCookie = isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" ? true : false;
// Récupère l'id de l'utilisateur connecté pour faire la correspondance avec ses commentaires
if ($isConnectedViaCookie) {
    $currentUser = $_COOKIE['userId'];
} else if ($isConnectedViaSession) {
    $currentUser = $_SESSION['userId'];
}
// Vérifie l'existence de commentaires sur la story
foreach ($comment->checkNumberOfCommentsInStory() as $key => $value) {
    $numberOfComments = $value[0];
}
// Création de commentaire
if (isset($_POST['submit'])) {
    if ($_POST['text'] == null) {
        $error['text'] = "Vous n'avez rien écrit...";
    }
    // Ternaire pour le feedback en cas d'erreur
    $commentValidationMessage = !isset($error['text']) ? "is-valid" : "is-invalid";
    // Si le formulaire ne contient pas d'erreur
    if (!isset($error)) {
        $comment->addComment();
        header('Location: ' . $_SERVER['PHP_SELF'] . "?id=" . $_GET['id']);
        die;
    }
}
// Update de commentaire
if (isset($_POST['updateComment'])) {
    if ($_POST['updatedCommentText'] == null) {
        $updateCommentError['updatedCommentText'] = "Vous n'avez rien écrit...";
    }
    // Ternaire pour le feedback en cas d'erreur
    $commentValidationMessage = !isset($updateCommentError['updatedCommentText']) ? "is-valid" : "is-invalid";
    // Si le formulaire ne contient pas d'erreur
    if (!isset($updateCommentError)) {
        $comment->updateComment();
        header('Location: ' . $_SERVER['PHP_SELF'] . "?id=" . $_GET['id']);
        die;
    }
}
// Suppression de commentaire
if (isset($_POST['deleteComment'])) {
    $comment->deleteComment();
    header('Location: ' . $_SERVER['PHP_SELF'] . "?id=" . $_GET['id']);
    die;
}
