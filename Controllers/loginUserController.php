<?php
// A la tentative de connexion de l'utilisateur
if (isset($_POST['connectUser'])) {
    $user = new User();
    // Vérification que les champs ne sont pas vides
    if ($_POST['modalLogin'] == null) {
        $loginModalError['modalLogin'] = "Champs obligatoire.";
    }
    if ($_POST['modalPassword'] == null) {
        $loginModalError['modalPassword'] = "Champs obligatoire.";
    }
    // Si les champs contiennent une valeur
    if (!isset($loginModalError)) {
        // Si les infos rentrées par l'utilisateur sont correctes
        if ($user->checkUsers()) {
            // Si l'utilisateur veut rester connecté en permanence, création de cookies
            if (isset($_POST['checkbox'])) {
                setcookie('userLogin', $user->getLogin(), time() + 60 * 60 * 24 * 30, '/');
                setcookie('userMail', $user->getMail(), time() + 60 * 60 * 24 * 30, '/');
                setcookie('userLastname', $user->getLastname(), time() + 60 * 60 * 24 * 30, '/');
                setcookie('userFirstname', $user->getFirstname(), time() + 60 * 60 * 24 * 30, '/');
                setcookie('userId', $user->getId(), time() + 60 * 60 * 24 * 30, '/');
                // Condition de redirection car la page d'inscription n'est pas accessible une fois loggé
                if ($_SERVER['REQUEST_URI'] == "/Views/addUser.php") {
                    header('Location: /index.php');
                    die;
                } else {
                    header('Location: ' . $_SERVER['REQUEST_URI']);
                    die;
                }
            } else {
                // Si l'utilisateur ne veut se logger que pour cette session
                $_SESSION['userLogin'] = $user->getLogin();
                $_SESSION['userMail'] = $user->getMail();
                $_SESSION['userLastname'] = $user->getLastname();
                $_SESSION['userFirstname'] = $user->getFirstname();
                $_SESSION['userId'] = $user->getId();
                // Condition de redirection car la page d'inscription n'est pas accessible une fois loggé
                if ($_SERVER['REQUEST_URI'] == "/Views/addUser.php") {
                    header('Location: /index.php');
                    die;
                } else {
                    header('Location: ' . $_SERVER['REQUEST_URI']);
                    die;
                }
            }
            // Si les infos rentrées par l'utilisateur sont incorrectes
        } else {
            $loginModalError['modalLog'] = "Mauvais login et/ou mot de passe.";
        }
    }
}
