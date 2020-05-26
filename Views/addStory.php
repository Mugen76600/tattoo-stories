<?php
require '../Controllers/addStoryController.php';
require '../Controllers/loginUserController.php';
require '../Controllers/cookiesWarningController.php';
require 'bodyTop.php';
?>

<body>
    <?php require 'navbar.php' ?>
    <div class="container-fluid">
        <div class="container">
            <h1 class="display-1 mb-5 mt-2 text-danger">Créez votre propre <span class="text-body">story</span></h1>
            <form enctype="multipart/form-data" action="" method="POST">
                <div class="form-group">
                    <label for="title">Titre de la story *</label>
                    <input type="text" class="form-control <?= isset($_POST['submit']) ? $titleValidationMessage : "" ?>" id="title" name="title" placeholder="Titre de la story" value="<?= isset($_POST['title']) ? $_POST['title'] : "" ?>" />
                    <div class="invalid-feedback">
                        <?= isset($titleValidationMessage) && $titleValidationMessage == "is-invalid" ? $error['title'] : "" ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="artist">Artiste ou salon (optionnel)</label>
                    <input type="text" class="form-control" id="artist" name="artist" placeholder="Nom de l'artiste ou du salon" value="<?= isset($_POST['artist']) ? $_POST['artist'] : "" ?>" />
                </div>
                <div class="form-group <?= isset($error['picture1']) ? "border border-danger p-2 rounded" : "" ?>">
                    <div class="row <?= !isset($error['picture1']) ? "border p-2 rounded" : "" ?>">
                        <div class="col-12 col-md-6">
                            <label for="picture1">Image de votre tatouage *</label>
                            <input type="file" class="form-control-file" id="picture1" name="picture1" data-preview=".preview1" /><i id="cancelPic1" class="far fa-times-circle text-danger"></i>
                            <small class="text-muted"><?= !isset($_POST['submit']) ? "Taille max : 5mo. Formats : jpg ou png" : "" ?></small>
                            <small class="text-danger"><?= isset($error['picture1']) ? $error['picture1'] : "" ?></small>
                        </div>
                        <div class="col-12 col-md-6"><img id="imgPreview1" class="preview1 img-fluid" /></div>
                    </div>
                </div>
                <div class="form-group <?= isset($error['picture2']) ? "border border-danger p-2 rounded" : "" ?>">
                    <div class="row <?= !isset($error['picture2']) ? "border p-2 rounded" : "" ?>">
                        <div class="col-12 col-md-6">
                            <label for="picture2">Deuxième image de votre tatouage (optionnelle)</label>
                            <input type="file" class="form-control-file" id="picture2" name="picture2" data-preview=".preview2" /><i id="cancelPic2" class="far fa-times-circle text-danger"></i>
                            <small class="text-muted"><?= !isset($_POST['submit']) ? "Taille max : 5mo. Formats : jpg ou png" : "" ?></small>
                            <small class="text-danger"><?= isset($error['picture2']) ? $error['picture2'] : "" ?></small>
                        </div>
                        <div class="col-12 col-md-6"><img id="imgPreview2" class="preview2 img-fluid" /></div>
                    </div>
                </div>
                <div class="form-group <?= isset($error['picture3']) ? "border border-danger p-2 rounded" : "" ?>">
                    <div class="row <?= !isset($error['picture3']) ? "border p-2 rounded" : "" ?>">
                        <div class="col-12 col-md-6">
                            <label for="picture3">Troisième image de votre tatouage (optionnelle)</label>
                            <input type="file" class="form-control-file" id="picture3" name="picture3" data-preview=".preview3" /><i id="cancelPic3" class="far fa-times-circle text-danger"></i>
                            <small class="text-muted"><?= !isset($_POST['submit']) ? "Taille max : 5mo. Formats : jpg ou png" : "" ?></small>
                            <small class="text-danger"><?= isset($error['picture3']) ? $error['picture3'] : "" ?></small>
                        </div>
                        <div class="col-12 col-md-6"><img id="imgPreview3" class="preview3 img-fluid" /></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="story">Racontez-nous votre histoire : *</label>
                    <textarea class="form-control <?= isset($_POST['submit']) ? $storyValidationMessage : "" ?>" id="story" name="story" rows="5" placeholder="Votre joli texte sans fautes..."><?= isset($_POST['story']) ? $_POST['story'] : "" ?></textarea>
                    <div class="invalid-feedback">
                        <?= isset($storyValidationMessage) && $storyValidationMessage == "is-invalid" ? $error['story'] : "" ?>
                    </div>
                    <small class="text-muted"><?= !isset($_POST['submit']) ? "Minimum 500 lettres" : "" ?></small>
                </div>
                <button type="button" class="btn btn-lg btn-danger float-right" data-toggle="modal" data-target="#confirmationModal">Publier</button>
                <!-- Modal de confirmation -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="confirmationModalLabel">Confirmation de la <span class="text-body">publication</span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Voulez-vous publier votre story ? Pas de faute d'orthographe ? Bon choix de photo ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">En fait non...</button>
                                <button type="submit" name="submit" class="btn btn-danger">Sûr de sûr !</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require 'footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/assets/scripts/loginUserModalScript.js"></script>
    <script src="/assets/scripts/addStoryScript.js"></script>
</body>

</html>