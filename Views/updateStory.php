<?php
require '../Controllers/updateStoryController.php';
require '../Controllers/loginUserController.php';
require '../Controllers/cookiesWarningController.php';
require 'bodyTop.php';
?>

<body>
    <?php require 'navbar.php' ?>
    <div class="container-fluid">
        <div class="container">
            <?php foreach ($story->detailsStory() as $key => $value) {
                // Vérification qu'un user est connecté
                if (!$isConnectedViaSession && !$isConnectedViaCookie) { ?>
                    <p class="display-4 my-5">Vous n'avez pas accès à cette page.</p>
                    <!-- Vérification que l'auteur de la story est bien le user connecté -->
                <?php } else if ($isConnectedViaCookie && $value[8] != $_COOKIE['userId'] || $isConnectedViaSession && $_SESSION['userId'] != $value[8]) { ?>
                    <p class="display-4 my-5">Vous n'avez pas accès à cette page.</p>
                <?php } else { ?>
                    <h1 class="display-1 mb-5 mt-2 text-danger">Modifiez votre <span class="text-body">story</span></h1>
                    <form enctype="multipart/form-data" action="" method="POST">
                        <div class="form-group">
                            <label for="title">Titre de la story *</label>
                            <input type="text" class="form-control <?= isset($_POST['submit']) ? $titleValidationMessage : "" ?>" id="title" name="title" placeholder="Titre de la story" value="<?= isset($_POST['title']) ? $_POST['title'] : $value[5] ?>" />
                            <div class="invalid-feedback">
                                <?= isset($titleValidationMessage) && $titleValidationMessage == "is-invalid" ? $error['title'] : "" ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="artist">Artiste ou salon (optionnel)</label>
                            <input type="text" class="form-control" id="artist" name="artist" placeholder="Nom de l'artiste ou du salon" value="<?= isset($_POST['artist']) ? $_POST['artist'] : $value[6] != "" ? $value[6] : "" ?>" />
                        </div>
                        <h4 class="h5 text-danger text-center mt-5"><?= $value[3] != "" || $value[4] != "" ? "Vos images :" : "Votre image :" ?></h4>
                        <div class="d-sm-flex justify-content-around text-center">
                            <!-- Image 1: obligatoire -->
                            <div class="my-5">
                                <a data-toggle="modal" data-target="#mandatoryPicModal"><img class="img-thumbnail preview1" src="<?= $value[2] ?>" alt="Principale image du tattoo" /></a>
                                <div>
                                    <label for="picture1">
                                        <i class="storyEditionBtn far fa-edit text-muted"></i>
                                    </label>
                                    <input hidden type="file" class="form-control-file" id="picture1" name="picture1" data-preview=".preview1" />
                                    <div><small class="text-danger"><?= isset($error['picture1']) ? $error['picture1'] : "" ?></small></div>
                                </div>
                            </div>
                            <!-- Image 2 -->
                            <?php if ($value[3] != "") { ?>
                                <div class="my-5">
                                    <a data-toggle="modal" data-target="#pic1Modal"><img id="thumbnail2" class="img-thumbnail preview2" src="<?= $value[3] ?>" alt="Autre image du tattoo" /></a>
                                    <div>
                                        <label for="picture2">
                                            <i class="mx-2 storyEditionBtn far fa-edit text-muted"></i>
                                        </label>
                                        <input hidden type="file" class="form-control-file" id="picture2" name="picture2" data-preview=".preview2" />
                                        <i id="cancelPic2" class="mx-2 far fa-times-circle text-danger"></i>
                                        <div><small class="text-danger"><?= isset($error['picture2']) ? $error['picture2'] : "" ?></small></div>
                                        <input hidden id="bufferInputPic2" name="bufferInputPic2" class="form-control" type="text" value="" />
                                    </div>
                                    <div><?= isset($_SESSION['suppressedPic2']) ? $_SESSION['suppressedPic2'] : "" ?></div>
                                </div>
                            <?php } else { ?>
                                <div class="my-5">
                                    <img id="thumbnail2" class="img-thumbnail preview2" src="/assets/img/placeholder.png" alt="Autre image du tattoo" />
                                    <div>
                                        <label for="picture2">
                                            <i class="mx-2 storyEditionBtn far fa-edit text-muted"></i>
                                        </label>
                                        <input hidden type="file" class="form-control-file" id="picture2" name="picture2" data-preview=".preview2" />
                                        <i id="cancelPic2" class="mx-2 far fa-times-circle text-danger"></i>
                                        <div><small class="text-danger"><?= isset($error['picture2']) ? $error['picture2'] : "" ?></small></div>
                                        <input hidden id="bufferInputPic2" name="bufferInputPic2" class="form-control" type="text" value="" />
                                    </div>
                                    <div><?= isset($_SESSION['suppressedPic2']) ? $_SESSION['suppressedPic2'] : "" ?></div>
                                </div>
                            <?php } ?>
                            <!-- Image 3 -->
                            <?php if ($value[4] != "") { ?>
                                <div class="my-5">
                                    <a data-toggle="modal" data-target="#pic2Modal"><img id="thumbnail3" class="img-thumbnail preview3" src="<?= $value[4] ?>" alt="Autre image du tattoo" /></a>
                                    <div>
                                        <label for="picture3">
                                            <i class="mx-2 storyEditionBtn far fa-edit text-muted"></i>
                                        </label>
                                        <input hidden type="file" class="form-control-file" id="picture3" name="picture3" data-preview=".preview3" />
                                        <i id="cancelPic3" class="mx-2 far fa-times-circle text-danger"></i>
                                        <div><small class="text-danger"><?= isset($error['picture3']) ? $error['picture3'] : "" ?></small></div>
                                        <input hidden id="bufferInputPic3" name="bufferInputPic3" class="form-control" type="text" value="" />
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="my-5">
                                    <img id="thumbnail3" class="img-thumbnail preview3" src="/assets/img/placeholder.png" alt="Autre image du tattoo" />
                                    <div>
                                        <label for="picture3">
                                            <i class="mx-2 storyEditionBtn far fa-edit text-muted"></i>
                                        </label>
                                        <input hidden type="file" class="form-control-file" id="picture3" name="picture3" data-preview=".preview3" />
                                        <i id="cancelPic3" class="mx-2 far fa-times-circle text-danger"></i>
                                        <div><small class="text-danger"><?= isset($error['picture3']) ? $error['picture3'] : "" ?></small></div>
                                        <input hidden id="bufferInputPic3" name="bufferInputPic3" class="form-control" type="text" value="" />
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="story">Votre histoire : *</label>
                            <textarea class="form-control <?= isset($_POST['submit']) ? $storyValidationMessage : "" ?>" id="story" name="story" rows="5" placeholder="Votre joli texte sans fautes..."><?= isset($_POST['story']) ? $_POST['story'] : $value[7] ?></textarea>
                            <div class="invalid-feedback">
                                <?= isset($storyValidationMessage) && $storyValidationMessage == "is-invalid" ? $error['story'] : "" ?>
                            </div>
                            <small class="text-muted"><?= !isset($_POST['submit']) ? "Minimum 500 lettres" : "" ?></small>
                        </div>
                        <button type="button" class="btn btn-lg btn-danger float-right" data-toggle="modal" data-target="#confirmationModal">Modifier</button>
                        <!-- Modal de confirmation -->
                        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="confirmationModalLabel">Confirmation de la <span class="text-body">modification</span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Voulez-vous modifier votre story ? Pas de faute d'orthographe ? Bon choix de photo ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">En fait non...</button>
                                        <button type="submit" name="submit" class="btn btn-danger">Sûr de sûr !</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            <?php }
            } ?>
        </div>
    </div>
    <?php require 'footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/assets/scripts/loginUserModalScript.js"></script>
    <script src="/assets/scripts/updateStoryScript.js"></script>
</body>

</html>