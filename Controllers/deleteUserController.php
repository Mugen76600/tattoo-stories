<?php
// Lorsque l'utilisateur confirme la suppression de son compte
if (isset($_POST['deleteUser'])) {
    // Scan les fichiers uploadés par tous les users
    $directoryScan = scandir(dirname(getcwd()) . "\assets\userUploads\\");
    if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] != "") {
        // Retrouve les fichiers que le user a uploadé puis les supprime
        foreach ($directoryScan as $key => $value) {
            if (strstr($value, "_" . $_SESSION['userId'] . "_")) {
                unlink(dirname(getcwd()) . "\assets\userUploads\\" . $value);
            }
        }
        // L'utilisateur est supprimé de la base, ses infos de login sont supprimées puis il est redirigé vers l'accueil
        $user->deleteUser();
        session_destroy();
        header('Location: /index.php');
        die;
        // Même procédure qu'au dessus mais pour un utilisateur loggé via des cookies
    } else if (isset($_COOKIE['userLogin'])) {
        foreach ($directoryScan as $key => $value) {
            if (strstr($value, "_" . $_COOKIE['userId'] . "_")) {
                unlink(dirname(getcwd()) . "\assets\userUploads\\" . $value);
            }
        }
        $user->deleteUser();
        setcookie('userLogin', "", time() - 1000, '/');
        setcookie('userMail', "", time() - 1000, '/');
        setcookie('userLastname', "", time() - 1000, '/');
        setcookie('userFirstname', "", time() - 1000, '/');
        setcookie('userId', "", time() - 1000, '/');
        header('Location: /index.php');
        die;
    }
}
