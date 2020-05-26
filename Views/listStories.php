<?php
require '../Controllers/listStoriesController.php';
require '../Controllers/loginUserController.php';
require '../Controllers/cookiesWarningController.php';
require 'bodyTop.php';
?>

<body>
    <?php require 'navbar.php' ?>
    <div class="container-fluid">
        <div class="container">
            <!-- Si une recherche est effectuée -->
            <?php if (isset($_GET['search'])) { ?>
                <h1 class="display-1 my-2 text-danger">
                    Résultat&#8226s de la recherche <span class="text-body"><?= $_GET['query'] ?></span>
                </h1>
                <div class="mb-5 btn-group dropright">
                    <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-search text-danger"></i>
                    </button>
                    <div class="dropdown-menu px-2 rounded">
                        <form action="" method="GET">
                            <input class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-danger" type="search" name="query" placeholder="Recherche" />
                            <div class="text-center mt-1">
                                <button class="btn btn-sm btn-danger" type="submit" name="search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if ($story->searchStory() == null) { ?>
                    <div>
                        <h1 class="display-1 mt-4 text-danger">
                            Désolé, nous n'avons rien <span class="text-body">trouvé</span>...
                        </h1>
                    </div>
                    <div>
                        <h1 class="display-1 my-5 text-danger">
                            Vous pouvez chercher par <span class="text-body">utilisateur</span>, <span class="text-body">date</span>, <span class="text-body">artiste</span>, <span class="text-body">titre de story</span>.
                        </h1>
                    </div>

                <?php } else { ?>
                    <?php foreach ($story->searchStory() as $key => $value) { ?>
                        <div class="m-4 pr-1 storiesCards" onclick="document.location = '/Views/detailsStory.php?id=<?= $value[0] ?>';">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <img class="w-100" src="<?= $value[2] ?>" alt="Thumbnail" />
                                </div>
                                <div class="col-12 col-md-8 d-flex flex-column">
                                    <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] != "") {
                                        if ($value[6] == $_SESSION['userId']) { ?>
                                            <i class="ownerCrown text-danger fas fa-crown"></i>
                                        <?php }
                                    } else if (isset($_COOKIE['userId']) && $_COOKIE['userId'] != "") {
                                        if ($value[6] == $_COOKIE['userId']) { ?>
                                            <i class="ownerCrown text-danger fas fa-crown"></i>
                                    <?php }
                                    } ?>
                                    <div class="mt-2 font-weight-bold text-danger h5"><?= $value[5] ?></div>
                                    <div class="mt-1">Publiée le <?= $value[1] ?> par <span class="font-weight-bold text-danger"><?= $value[7] ?></span></div>
                                    <div class="my-auto"><?= mb_substr($value[8], 0, 200) ?>...</div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <!-- Si aucune recherche n'est effectuée -->
                <h1 class="display-1 my-2 text-danger">
                    Toutes les <span class="text-body">stories</span>
                </h1>
                <div class="mb-5 btn-group dropright">
                    <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-search text-danger"></i>
                    </button>
                    <div class="dropdown-menu px-2 rounded">
                        <form action="" method="GET">
                            <input class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-danger" type="search" name="query" placeholder="Recherche" />
                            <div class="text-center mt-1">
                                <button class="btn btn-sm btn-danger" type="submit" name="search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php foreach ($story->fetchAllStories() as $key => $value) { ?>
                    <div class="m-4 pr-1 storiesCards" onclick="document.location = '/Views/detailsStory.php?id=<?= $value[0] ?>';">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <img class="w-100" src="<?= $value[2] ?>" alt="Thumbnail" />
                            </div>
                            <div class="col-12 col-md-8 d-flex flex-column">
                                <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] != "") {
                                    if ($value[6] == $_SESSION['userId']) { ?>
                                        <i class="ownerCrown text-danger fas fa-crown"></i>
                                    <?php }
                                } else if (isset($_COOKIE['userId']) && $_COOKIE['userId'] != "") {
                                    if ($value[6] == $_COOKIE['userId']) { ?>
                                        <i class="ownerCrown text-danger fas fa-crown"></i>
                                <?php }
                                } ?>
                                <div class="mt-2 font-weight-bold text-danger h5"><?= $value[5] ?></div>
                                <div class="mt-1">Publiée le <?= $value[1] ?> par <span class="font-weight-bold text-danger"><?= $value[7] ?></span></div>
                                <div class="my-auto text-break"><?= mb_substr($value[8], 0, 200) ?>...</div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <?php require 'footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/assets/scripts/loginUserModalScript.js"></script>
    <script src="/assets/scripts/listStoriesScript.js"></script>
</body>

</html>