<?php
require '../Controllers/addUserController.php';
require '../Controllers/loginUserController.php';
require '../Controllers/cookiesWarningController.php';
require 'bodyTop.php';
?>

<body>
    <?php require 'navbar.php' ?>
    <div class="container-fluid">
        <div class="container">
            <h1 class="display-1 mb-5 mt-2 text-danger">Formulaire <span class="text-body">d'inscription</span></h1>
            <?php if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] != "" || isset($_COOKIE['userLogin'])) { ?>
                <p class="display-4 my-5">Vous ne pouvez pas vous inscrire si vous êtes déjà connecté !</p>
            <?php } else { ?>
                <form action="" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="lastname">Nom</label>
                            <input type="text" class="form-control <?= isset($_POST['submit']) ? $lastnameValidationMessage : "" ?>" name="lastname" value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : "" ?>" id="lastname" placeholder="Nom" />
                            <div class="invalid-feedback">
                                <?= isset($lastnameValidationMessage) && $lastnameValidationMessage == "is-invalid" ? $error['lastname'] : "" ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="firstname">Prénom</label>
                            <input type="text" class="form-control <?= isset($_POST['submit']) ? $firstnameValidationMessage : "" ?>" name="firstname" value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : "" ?>" id="firstname" placeholder="Prénom" />
                            <div class="invalid-feedback">
                                <?= isset($firstnameValidationMessage) && $firstnameValidationMessage == "is-invalid" ? $error['firstname'] : "" ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="mail">Adresse mail</label>
                            <input type="email" class="form-control <?= isset($_POST['submit']) ? $mailValidationMessage : "" ?>" name="mail" value="<?= isset($_POST['mail']) ? $_POST['mail'] : "" ?>" id="mail" placeholder="Adresse mail" />
                            <div class="invalid-feedback">
                                <?= isset($mailValidationMessage) && $mailValidationMessage == "is-invalid" ? $error['mail'] : "" ?>
                            </div>
                            <small class="form-text text-muted"><?= !isset($_POST['submit']) ? $mailHelp : "" ?></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="login">Pseudonyme</label>
                            <input type="text" class="form-control <?= isset($_POST['submit']) ? $loginValidationMessage : "" ?>" name="login" value="<?= isset($_POST['login']) ? $_POST['login'] : "" ?>" id="login" placeholder="Pseudonyme" />
                            <div class="invalid-feedback">
                                <?= isset($loginValidationMessage) && $loginValidationMessage == "is-invalid" ? $error['login'] : "" ?>
                            </div>
                            <small class="form-text text-muted"><?= !isset($_POST['submit']) ? $loginHelp : "" ?></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control <?= isset($_POST['submit']) ? $passwordValidationMessage : "" ?>" name="password" id="password" placeholder="Mot de passe" />
                            <div class="invalid-feedback">
                                <?= isset($passwordValidationMessage) && $passwordValidationMessage == "is-invalid" ? $error['password'] : "" ?>
                            </div>
                            <small class="form-text text-muted"><?= !isset($_POST['submit']) ? $passwordHelp : "" ?></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="confirmPassword">Confirmation mot de passe</label>
                            <input type="password" class="form-control <?= isset($_POST['submit']) ? $confirmPasswordValidationMessage : "" ?>" name="confirmPassword" id="confirmPassword" placeholder="Confirmation mot de passe" />
                            <div class="invalid-feedback">
                                <?= isset($confirmPasswordValidationMessage) && $confirmPasswordValidationMessage == "is-invalid" ? $error['confirmPassword'] : "" ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input <?= isset($_POST['submit']) ? $checkAgeValidationMessage : "" ?>" name="checkAge" <?= isset($_POST['checkAge']) ? "checked" : "" ?> id="checkAge" />
                            <label class="custom-control-label" for="checkAge">En cochant cette case, je confirme avoir atteint la majorité dans mon pays de résidence</label>
                            <div class="invalid-feedback">
                                <?= isset($checkAgeValidationMessage) && $checkAgeValidationMessage == "is-invalid" ? $error['checkAge'] : "" ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-lg float-right btn-danger">S'INSCRIRE</button>
                </form>
            <?php } ?>
        </div>
    </div>
    <?php require 'footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/assets/scripts/loginUserModalScript.js"></script>
    <script src="/assets/scripts/addUserScript.js"></script>
</body>

</html>