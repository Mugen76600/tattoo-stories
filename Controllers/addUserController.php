<?php
session_start();
date_default_timezone_set("Europe/Paris");
require '../Models/Database.php';
require '../Models/User.php';
// Regex
$namesPattern = "/^[a-zA-Züéâäàåçêëèïîìôöòûùÿáíóúñãõý]{2,50}([\s-][a-zA-Züéâäàåçêëèïîìôöòûùÿáíóúñãõý]{2,50})?$/";
$loginPattern = "/^[\S]{2,20}$/";
$mailPattern = "/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/";
$passwordPattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*\W).{8,}$/";
// Messages d'aide sous les inputs
$passwordHelp = "Au moins huit (8) caractères dont une (1) majuscule, une (1) minuscule, un (1) chiffre et un (1) caractère spécial";
$loginHelp = "Le pseudo choisi ne doit pas dépasser vingt (20) caractères";
$mailHelp = "Votre adresse mail ne sera jamais utilisée à des fins commerciales";
// Envoi du formulaire d'inscription
if (isset($_POST['submit'])) {
    $user = new User();
    // Vérifications nom
    if ($_POST['lastname'] == null) {
        $error['lastname'] = "Veuillez renseigner votre nom";
    } else if (!preg_match($namesPattern, $_POST['lastname'])) {
        $error['lastname'] = "Un ou plusieurs caractères ne sont pas autorisés";
    }
    // Vérifications prénom
    if ($_POST['firstname'] == null) {
        $error['firstname'] = "Veuillez renseigner votre prénom";
    } else if (!preg_match($namesPattern, $_POST['firstname'])) {
        $error['firstname'] = "Un ou plusieurs caractères ne sont pas autorisés";
    }
    // Vérifications mail
    if ($_POST['mail'] == null) {
        $error['mail'] = "Veuillez renseigner votre adresse mail";
    } else if (!preg_match($mailPattern, $_POST['mail'])) {
        $error['mail'] = "Un ou plusieurs caractères ne sont pas autorisés";
    } else if ($user->checkMailAvailibility() != "") {
        $error['mail'] = "Cette adresse mail est déjà utilisée";
    }
    // Vérifications login
    if ($_POST['login'] == null) {
        $error['login'] = "Veuillez choisir un pseudonyme";
    } else if (!preg_match($loginPattern, $_POST['login'])) {
        $error['login'] = "Un ou plusieurs caractères ne sont pas autorisés";
    } else if ($user->checkPseudoAvailibility() != "") {
        $error['login'] = "Ce pseudonyme est déjà utilisé";
    }
    // Vérification âge
    if (!isset($_POST['checkAge'])) {
        $error['checkAge'] = "Vous devez confirmer être majeur·e pour continuer";
    }
    // Vérifications confirmation mot de passe
    if ($_POST['confirmPassword'] == null || !preg_match($passwordPattern, $_POST['password']) || isset($error)) {
        $error['confirmPassword'] = "Veuillez confirmer le mot de passe";
    } else if ($_POST['confirmPassword'] != $_POST['password']) {
        $error['confirmPassword'] = "Retapez le même mot de passe pour confirmer";
    }
    // Vérifications mot de passe
    if (!preg_match($passwordPattern, $_POST['password']) || isset($error)) {
        $error['password'] = "Au moins huit (8) caractères dont une (1) majuscule, une (1) minuscule, un (1) chiffre et un (1) caractère spécial";
    } else if (isset($error['confirmPassword'])) {
        $error['password'] = "La confirmation a échoué, veuillez retaper votre mot de passe";
    } else if ($_POST['password'] == null) {
        $error['password'] = "Veuillez choisir un mot de passe";
    }
    // Ternaires pour affichage des erreurs
    $lastnameValidationMessage = !isset($error['lastname']) ? "is-valid" : "is-invalid";
    $firstnameValidationMessage = !isset($error['firstname']) ? "is-valid" : "is-invalid";
    $mailValidationMessage = !isset($error['mail']) ? "is-valid" : "is-invalid";
    $loginValidationMessage = !isset($error['login']) ? "is-valid" : "is-invalid";
    $passwordValidationMessage = !isset($error['password']) ? "is-valid" : "is-invalid";
    $confirmPasswordValidationMessage = !isset($error['confirmPassword']) ? "is-valid" : "is-invalid";
    $checkAgeValidationMessage = !isset($error['checkAge']) ? "is-valid" : "is-invalid";
    // Création utilisateur s'il n'y aucune erreur
    if (!isset($error)) {
        $user->addUser();
        header('Location: ../Views/redirectAddUser.php');
        die;
    }
}
