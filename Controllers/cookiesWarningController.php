<?php
// Si l'utilisateur accepte les cookies sur la bannière, crée un cookie d'un mois permettant de ne pas réafficher cette dernière puis redirige vers la page en cours
if (isset($_POST['agreeCookies'])) {
    // Vérifie si un paramètre d'id existe dans l'url
    $parameterIdExists = $_GET['id'] ? '?id=' . $_GET['id'] : '';
    setcookie('acceptedCookies', true, time() + 60 * 60 * 24 * 30, '/');
    header('Location: ' . $_SERVER['PHP_SELF'] . $parameterIdExists);
    die;
}
