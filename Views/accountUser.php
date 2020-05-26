<?php
require '../Controllers/accountUserController.php';
require '../Controllers/updateUserController.php';
require '../Controllers/deleteUserController.php';
require '../Controllers/loginUserController.php';
require '../Controllers/cookiesWarningController.php';
require 'bodyTop.php';
?>

<body>
    <?php require 'navbar.php' ?>
    <div class="container-fluid">
        <div class="container">
            <?php if (!isset($_SESSION['userLogin']) && !isset($_COOKIE['userLogin'])) { ?>
                <p class="display-4 my-5">Veuillez vous connecter pour accéder à vos informations personnelles.</p>
            <?php } else { ?>
                <h1 class="display-1 mb-5 mt-2 text-danger">Mon <span class="text-body">compte</span></h1>
                <div class="row">
                    <!-- Section stories -->
                    <div class="col-12 col-md-9">
                        <div class="text-danger h4">Mes <span class="text-body">stories</span></div>
                        <?php foreach ($story->listUserStories() as $key => $value) { ?>
                            <div class="m-4 pr-1 storiesCards">
                                <div class="row">
                                    <div class="col-12 col-md-2" onclick="document.location = '/Views/detailsStory.php?id=<?= $value[0] ?>';">
                                        <img class="w-100" src="<?= $value[2] ?>" alt="Thumbnail" />
                                    </div>
                                    <div class="col-12 col-md-10 d-flex flex-column">
                                        <div class="h-100" onclick="document.location = '/Views/detailsStory.php?id=<?= $value[0] ?>';">
                                            <div>
                                                <p class="m-0 text-danger"><?= $value[5] ?></p>
                                            </div>
                                            <div>
                                                <p class="m-0">Publiée le <?= $value[1] ?></p>
                                            </div>
                                        </div>
                                        <a data-toggle="modal" data-target="#deletionConfirmationModal<?= $value[0] ?>"><i class="deleteStoryIcon far fa-times-circle text-danger"></i></a>
                                        <!-- Modal de confirmation suppression story -->
                                        <div class="modal fade" id="deletionConfirmationModal<?= $value[0] ?>" tabindex="-1" role="dialog" aria-labelledby="deletionConfirmationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-danger" id="deletionConfirmationModalLabel">Confirmation de la <span class="text-body">suppression</span></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="" method="post">
                                                        <div class="modal-body">
                                                            Voulez-vous supprimer votre story ? Vous ne pourrez plus la récupérer et les images seront perdues.
                                                            <input hidden type="text" name="pic1" value="<?= $value[2] ?>" />
                                                            <input hidden type="text" name="pic2" value="<?= $value[3] ?>" />
                                                            <input hidden type="text" name="pic3" value="<?= $value[4] ?>" />
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">En fait non...</button>
                                                            <button type="submit" name="deleteStory" value="<?= $value[0] ?>" class="btn btn-danger">Sûr de sûr !</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Section infos user -->
                    <div class="col-12 col-md-3">
                        <div class="text-danger h4">
                            Mes <span class="text-body">infos</span>
                        </div>
                        <!-- Boutons d'update et de déconnexion -->
                        <div>
                            <a class="userEditionBtn" data-toggle="modal" data-target="#updateUserModal">
                                <i class="fas fa-user-edit text-body"></i>
                            </a>
                            <a class="disconnectUserBtn" data-toggle="modal" data-target="#deconnectUserModal">
                                <i class="fas fa-plug text-body mx-2"></i>
                            </a>
                            <a class="deleteUserBtn" data-toggle="modal" data-target="#deleteUserModal">
                                <i class="far fa-trash-alt text-danger"></i>
                            </a>
                        </div>
                        <!-- Affichage des infos user -->
                        <?php foreach ($user->getInfoUserForUpdate() as $key => $value) { ?>
                            <div class="mt-4 text-danger">Nom : <span class="text-body"><?= $value[2] ?></span></div>
                            <div class="my-3 text-danger">Prénom : <span class="text-body"><?= $value[1] ?></span></div>
                            <div class="my-3 text-danger">Mail : <span class="text-body"><?= $value[3] ?></span></div>
                            <div class="my-3 text-danger">Pseudo : <span class="text-body"><?= $value[4] ?></span></div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- Modal update user -->
    <form action="" method="POST">
        <div class="modal fade <?= isset($updateUserModalError) ? "show" : "" ?>" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="updateUserModalTitle">Modification de <span class="text-body">profil</span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        foreach ($user->getInfoUserForUpdate() as $key => $value) { ?>
                            <div class="form-group">
                                <label for="lastname">Nom</label>
                                <input type="text" class="form-control <?= isset($_POST['updateUser']) ? $lastnameValidationMessage : "" ?>" name="lastname" value="<?= $value[2] ?>" id="lastname" placeholder="Nom" />
                                <div class="invalid-feedback">
                                    <?= isset($lastnameValidationMessage) && $lastnameValidationMessage == "is-invalid" ? $updateUserModalError['lastname'] : "" ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="firstname">Prénom</label>
                                <input type="text" class="form-control <?= isset($_POST['updateUser']) ? $firstnameValidationMessage : "" ?>" name="firstname" value="<?= $value[1] ?>" id="firstname" placeholder="Prénom" />
                                <div class="invalid-feedback">
                                    <?= isset($firstnameValidationMessage) && $firstnameValidationMessage == "is-invalid" ? $updateUserModalError['firstname'] : "" ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mail">Adresse mail</label>
                                <input type="email" class="form-control <?= isset($_POST['updateUser']) ? $mailValidationMessage : "" ?>" name="mail" value="<?= $value[3] ?>" id="mail" placeholder="Adresse mail" />
                                <div class="invalid-feedback">
                                    <?= isset($mailValidationMessage) && $mailValidationMessage == "is-invalid" ? $updateUserModalError['mail'] : "" ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="login">Pseudonyme</label>
                                <input type="text" class="form-control <?= isset($_POST['updateUser']) ? $loginValidationMessage : "" ?>" name="login" value="<?= $value[4] ?>" id="login" placeholder="Pseudonyme" />
                                <div class="invalid-feedback">
                                    <?= isset($loginValidationMessage) && $loginValidationMessage == "is-invalid" ? $updateUserModalError['login'] : "" ?>
                                </div>
                            </div>
                            <div class="accordion" id="passwordAccordion">
                                <button class="btn btn-link text-danger" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Modifier mot de passe
                                </button>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#passwordAccordion">
                                    <div class="form-group">
                                        <label for="origPassword">Ancien mot de passe</label>
                                        <input type="password" class="form-control <?= isset($_POST['updateUser']) ? $origPasswordValidationMessage : "" ?>" name="origPassword" id="origPassword" placeholder="Ancien mot de passe" />
                                        <div class="invalid-feedback">
                                            <?= isset($origPasswordValidationMessage) && $origPasswordValidationMessage == "is-invalid" ? $updateUserModalError['origPassword'] : "" ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="newPassword">Nouveau mot de passe</label>
                                        <input type="password" class="form-control <?= isset($_POST['updateUser']) ? $newPasswordValidationMessage : "" ?>" name="newPassword" id="newPassword" placeholder="Nouveau mot de passe" />
                                        <div class="invalid-feedback">
                                            <?= isset($newPasswordValidationMessage) && $newPasswordValidationMessage == "is-invalid" ? $updateUserModalError['newPassword'] : "" ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmNewPassword">Confirmation nouveau mot de passe</label>
                                        <input type="password" class="form-control <?= isset($_POST['updateUser']) ? $confirmNewPasswordValidationMessage : "" ?>" name="confirmNewPassword" id="confirmNewPassword" placeholder="Confirmation nouveau mot de passe" />
                                        <div class="invalid-feedback">
                                            <?= isset($confirmNewPasswordValidationMessage) && $confirmNewPasswordValidationMessage == "is-invalid" ? $updateUserModalError['confirmNewPassword'] : "" ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" name="updateUser" class="btn btn-danger">Modifier</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php require 'footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/assets/scripts/loginUserModalScript.js"></script>
    <script src="/assets/scripts/accountUserScript.js"></script>
    <script src="/assets/scripts/updateUserModalScript.js"></script>
</body>

</html>