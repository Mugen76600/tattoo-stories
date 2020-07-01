<?php
require '../Controllers/detailsStoryController.php';
require '../Controllers/loginUserController.php';
require '../Controllers/cookiesWarningController.php';
require 'bodyTop.php';
?>

<body>
    <?php require 'navbar.php' ?>
    <div class="container-fluid">
        <div class="container">
            <?php foreach ($story->detailsStory() as $key => $value) { ?>
                <h1 class="display-1 text-center detailsStoryMargin mt-5"><?= $value[5] ?></h1>
                <div class="text-center detailsStoryMargin"><img class="img-fluid" src="<?= $value[2] ?>" alt="Story header" /></div>
                <h2 class="h4">
                    Publiée le <?= $value[1] ?> par <span class="font-weight-bold text-danger"><?= $value[9] ?></span>
                    <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] != "") {
                        if ($value[8] == $_SESSION['userId']) { ?>
                            <a href="/Views/updateStory.php?id=<?= $value[0] ?>" class="ml-3"><i class="storyEditionBtn far fa-edit text-muted"></i></a>
                        <?php }
                    } else if (isset($_COOKIE['userId']) && $_COOKIE['userId'] != "") {
                        if ($value[8] == $_COOKIE['userId']) { ?>
                            <a href="/Views/updateStory.php?id=<?= $value[0] ?>" class="ml-3"><i class="storyEditionBtn far fa-edit text-muted"></i></a>
                    <?php }
                    } ?>
                </h2>
                <?php if ($value[6] != "") { ?>
                    <h3 class="h5 mt-3">Encré par <span class="font-weight-bold"><a class="text-danger text-decoration-none" target="_blank" href="https://www.google.com/search?q=<?= $value[6] ?>"><?= $value[6] ?></a></span></h3>
                <?php } ?>
                <p class="mt-5 detailsStoryMargin text-break"><?= nl2br($value[7]) ?></p>
                <?php if ($value[3] != "" || $value[4] != "") { ?>
                    <h4 class="h5 text-danger"><?= $value[3] != "" && $value[4] != "" ? "Plus d'images :" : "Une autre pour la route :" ?></h4>
                    <div class="d-sm-flex justify-content-around text-center">
                        <?php if ($value[3] != "") { ?>
                            <div class="my-5"><a data-toggle="modal" data-target="#pic1Modal"><img class="img-thumbnail" src="<?= $value[3] ?>" alt="Autre image du tattoo" /></a></div>
                        <?php } ?>
                        <?php if ($value[4] != "") { ?>
                            <div class="my-5"><a data-toggle="modal" data-target="#pic2Modal"><img class="img-thumbnail" src="<?= $value[4] ?>" alt="Autre image du tattoo" /></a></div>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>
            <?php if (isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" || isset($_SESSION['userId']) && $_SESSION['userId'] != "") { ?>
                <a class="toggleAddComment text-decoration-none text-danger" data-toggle="collapse" href="#commentForm" role="button">Ajouter un commentaire</a>
                <div class="collapse mb-5 <?= isset($error) ? "error" : "" ?>" id="commentForm">
                    <div class="card card-body border-danger">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="title">Titre du commentaire</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Le titre est optionnel" value="<?= isset($_POST['title']) ? $_POST['title'] : "" ?>" />
                            </div>
                            <div class="form-group">
                                <label for="text">Votre commentaire : *</label>
                                <small class="text-muted d-block mb-1">Une fois publié, vous aurez 10 minutes pour modifier ou supprimer le commentaire</small>
                                <textarea class="form-control <?= isset($_POST['submit']) ? $commentValidationMessage : "" ?>" id="text" name="text" rows="5" placeholder="Un petit commentaire sympa"><?= isset($_POST['text']) ? $_POST['text'] : "" ?></textarea>
                                <div class="invalid-feedback">
                                    <?= isset($commentValidationMessage) && $commentValidationMessage == "is-invalid" ? $error['text'] : "" ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-large btn-danger float-right" name="submit">Publier</button>
                        </form>
                    </div>
                </div>
            <?php } else { ?>
                <a class="loginButton" data-toggle="modal" data-target="#logModal">
                    <div class="text-danger">Vous devez être connecté&#8226e pour commenter</div>
                </a>
            <?php } ?>
            <?php if ($numberOfComments == 0) { ?>
                <div class="mt-5">Il n'y a aucun commentaire pour le moment</div>
                <?php } else {
                foreach ($comment->showComments() as $key => $value) { ?>
                    <div class="m-4 pr-1 card card-body">
                        <div class="row">
                            <div class="col-12 d-flex flex-column">
                                <div class="font-weight-bold text-danger h5"><?= $value[1] != "" ? $value[1] : "" ?></div>
                                <div>
                                    Publié le <?= $value[0] ?> par <span class="font-weight-bold text-danger"><?= $value[3] ?></span>
                                    <!-- Permet à l'utilisateur de modifier ou supprimer son commentaire durant 10 minutes -->
                                    <?php if (isset($currentUser) && $currentUser == $value[5] && (time() - strtotime($value[4])) < (60 * 10)) { ?>
                                        <span class="mx-2">
                                            <a class="commentEditionBtn" data-toggle="modal" data-target="#updateCommentModal<?= $value[6] ?>">
                                                <i class="far fa-edit text-muted"></i>
                                            </a>
                                        </span>
                                        <span>
                                            <a class="deleteCommentBtn" data-toggle="modal" data-target="#deleteCommentModal">
                                                <i class="far fa-times-circle text-danger"></i>
                                            </a>
                                        </span>
                                    <?php } ?>
                                </div>
                                <div class="mt-3 text-break"><?= $value[2] ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal d'update de commentaire -->
                    <form action="" method="POST">
                        <div class="modal fade <?= isset($updateCommentError) ? "show" : "" ?>" id="updateCommentModal<?= $value[6] ?>" tabindex="-1" role="dialog" aria-labelledby="updateCommentModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="updateCommentModalLabel">Modification du <span class="text-body">commentaire</span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="updatedCommentTitle">Titre du commentaire</label>
                                            <input type="text" class="form-control" id="updatedCommentTitle" name="updatedCommentTitle" placeholder="Le titre est optionnel" value="<?= isset($_POST['updatedCommentTitle']) ? $_POST['updatedCommentTitle'] : $value[1] != "" ? $value[1] : "" ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label for="updatedCommentText">Votre nouveau commentaire : *</label>
                                            <textarea class="form-control <?= isset($_POST['updateComment']) ? $commentValidationMessage : "" ?>" id="updatedCommentText" name="updatedCommentText" rows="5" placeholder="Un petit commentaire sympa"><?= isset($_POST['updatedCommentText']) ? $_POST['updatedCommentText'] : $value[2] ?></textarea>
                                            <div class="invalid-feedback">
                                                <?= isset($commentValidationMessage) && $commentValidationMessage == "is-invalid" ? $updateCommentError['updatedCommentText'] : "" ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">En fait non...</button>
                                        <button class="btn btn-danger" type="submit" name="updateComment">Modifier</button>
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
    <script src="/assets/scripts/detailsStoryScript.js"></script>
</body>

</html>