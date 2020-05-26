<?php
// Regex
$namesPattern = "/^[a-zA-Züéâäàåçêëèïîìôöòûùÿáíóúñãõý]{2,50}([\s-][a-zA-Züéâäàåçêëèïîìôöòûùÿáíóúñãõý]{2,50})?$/";
$loginPattern = "/^[\S]{2,20}$/";
$mailPattern = "/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/";
$passwordPattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*\W).{8,}$/";
$user = new User();
if (isset($_POST['updateUser'])) {
    // Vérifications nom
    if ($_POST['lastname'] == null) {
        $updateUserModalError['lastname'] = "Veuillez renseigner votre nom";
    } else if (!preg_match($namesPattern, $_POST['lastname'])) {
        $updateUserModalError['lastname'] = "Un ou plusieurs caractères ne sont pas autorisés";
    }
    // Vérifications prénom
    if ($_POST['firstname'] == null) {
        $updateUserModalError['firstname'] = "Veuillez renseigner votre prénom";
    } else if (!preg_match($namesPattern, $_POST['firstname'])) {
        $updateUserModalError['firstname'] = "Un ou plusieurs caractères ne sont pas autorisés";
    }
    // Vérifications mail
    foreach ($user->getInfoUserForUpdate() as $key => $value) {
        $origMail = $value[3];
    }
    // Ternaire vérifie si le mail a été modifié
    $keptMail = $origMail == $_POST['mail'] ? true : false;
    if ($_POST['mail'] == null) {
        $updateUserModalError['mail'] = "Veuillez renseigner votre adresse mail";
    } else if (!preg_match($mailPattern, $_POST['mail'])) {
        $updateUserModalError['mail'] = "Un ou plusieurs caractères ne sont pas autorisés";
    } else if (!$keptMail && $user->checkMailAvailibility() != "") {
        $updateUserModalError['mail'] = "Cette adresse mail est déjà utilisée";
    }
    // Vérifications login
    foreach ($user->getInfoUserForUpdate() as $key => $value) {
        $origLogin = $value[4];
    }
    // Ternaire vérifie si le login a été modifié
    $keptLogin = $origLogin == $_POST['login'] ? true : false;
    if ($_POST['login'] == null) {
        $updateUserModalError['login'] = "Veuillez choisir un pseudonyme";
    } else if (!preg_match($loginPattern, $_POST['login'])) {
        $updateUserModalError['login'] = "Un ou plusieurs caractères ne sont pas autorisés";
    } else if (!$keptLogin && $user->checkPseudoAvailibility() != "") {
        $updateUserModalError['login'] = "Ce pseudonyme est déjà utilisé";
    }
    // Vérifications mot de passe
    if ($_POST['origPassword'] != "" || $_POST['newPassword'] != "" || $_POST['confirmNewPassword'] != "") {
        // Récupération du password en bdd
        foreach ($user->getInfoUserForUpdate() as $key => $value) {
            $origPassword = $value[5];
        }
        // Ternaire vérifiant la correspondance entre le password entré et le password en bdd
        $passwordHashVerification = password_verify($_POST['origPassword'], $origPassword) ? true : false;
        // Ternaire vérifiant la confirmation du nouveau password
        $newPasswordMatch = $_POST['newPassword'] == $_POST['confirmNewPassword'] ? true : false;
        // Ternaire vérifiant la conformité du nouveau password choisi
        $checkRegexNewPassword = preg_match($passwordPattern, $_POST['newPassword']) && preg_match($passwordPattern, $_POST['confirmNewPassword']) ? true : false;
        // Gestion des différentes erreurs
        if (!$passwordHashVerification) {
            $updateUserModalError['origPassword'] = "Veuiller entrer votre mot de passe actuel";
            $updateUserModalError['newPassword'] = "Veuillez rentrer votre mot de passe actuel pour en choisir un nouveau";
            $updateUserModalError['confirmNewPassword'] = "Veuillez rentrer votre mot de passe actuel pour en choisir un nouveau";
        } else if ($passwordHashVerification && !$newPasswordMatch) {
            $updateUserModalError['origPassword'] = "Veuiller de nouveau entrer votre mot de passe actuel";
            $updateUserModalError['newPassword'] = "Erreur lors de la confirmation, assurez-vous de taper deux fois le même mot de passe";
            $updateUserModalError['confirmNewPassword'] = "Erreur lors de la confirmation, assurez-vous de taper deux fois le même mot de passe";
        } else if ($passwordHashVerification && !$checkRegexNewPassword) {
            $updateUserModalError['origPassword'] = "Veuiller de nouveau entrer votre mot de passe actuel";
            $updateUserModalError['newPassword'] = "Au moins huit (8) caractères dont une (1) majuscule, une (1) minuscule, un (1) chiffre et un (1) caractère spécial";
            $updateUserModalError['confirmNewPassword'] = "Au moins huit (8) caractères dont une (1) majuscule, une (1) minuscule, un (1) chiffre et un (1) caractère spécial";
        }
    }
    // Ternaires pour affichage des erreurs
    $lastnameValidationMessage = !isset($updateUserModalError['lastname']) ? "is-valid" : "is-invalid";
    $firstnameValidationMessage = !isset($updateUserModalError['firstname']) ? "is-valid" : "is-invalid";
    $mailValidationMessage = !isset($updateUserModalError['mail']) ? "is-valid" : "is-invalid";
    $loginValidationMessage = !isset($updateUserModalError['login']) ? "is-valid" : "is-invalid";
    $origPasswordValidationMessage = !isset($updateUserModalError['origPassword']) ? "is-valid" : "is-invalid";
    $newPasswordValidationMessage = !isset($updateUserModalError['newPassword']) ? "is-valid" : "is-invalid";
    $confirmNewPasswordValidationMessage = !isset($updateUserModalError['confirmNewPassword']) ? "is-valid" : "is-invalid";
    // Ternaire pour vérifier si le password est changé ou pas
    $isNotUpdatingPassword = $_POST['origPassword'] == "" && $_POST['newPassword'] == "" && $_POST['confirmNewPassword'] == "" ? true : false;
    // Si le formulaire est conforme, la méthode est appliquée avec le paramètre correspondant selon que le password soit changé ou non
    if ($isNotUpdatingPassword && !isset($updateUserModalError)) {
        $user->updateUser("withoutPassword");
        header('Location: ' . $_SERVER['PHP_SELF']);
        die;
    } else if (!$isNotUpdatingPassword && !isset($updateUserModalError)) {
        $user->updateUser("withPassword");
        header('Location: ' . $_SERVER['PHP_SELF']);
        die;
    }
}
