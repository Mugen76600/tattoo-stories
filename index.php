<?php
require 'Controllers/indexController.php';
require 'Controllers/loginUserController.php';
require 'Controllers/cookiesWarningController.php';
require 'Views/bodyTop.php';
?>

<body>
    <?php require 'Views/navbar.php' ?>
    <div class="container-fluid">
        <div class="container">
            <a class="text-decoration-none" data-toggle="collapse" href="#conceptText" role="button">
                <h1 class="display-1 my-2 text-danger">
                    Bienvenue sur Tattoo <span class="text-body">Stories</span>
                </h1>
            </a>
            <div class="mb-5 btn-group dropright">
                <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-search text-danger"></i>
                </button>
                <div class="dropdown-menu px-2 rounded">
                    <form action="/Views/listStories.php" method="GET">
                        <input class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-danger" type="search" name="query" placeholder="Recherche" />
                        <div class="text-center mt-1">
                            <button class="btn btn-sm btn-danger" type="submit" name="search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="collapse mb-5" id="conceptText">
                <div class="card card-body border-danger">
                    De nombreux sites intègrent un aspect social, qu’il s’agisse de partager un
                    article ou de le commenter. Depuis l’avènement de Facebook et Twitter,
                    puis ceux qui en ont découlés, tout le monde est connecté en permanence.
                    Que ce soit pour raconter sa journée ou donner son opinion, la visibilité
                    est globale et le message facilement accessible.
                    </br></br>
                    Dans cet environnement, des sites se sont spécialisés, par exemple dans le
                    partage de recettes de cuisine ou le partage d’artworks, et permettent une
                    interaction directe avec l’auteur‧e.
                    </br></br>
                    C’est en partie de là que m’est venue l’idée de Tattoo Stories.
                    Pourquoi en partie ? Parce que je suis moi-même tatoué, et je ne pense pas
                    être la seule personne tatouée à qui on ait jamais demandé “Pourquoi tu
                    as fait ce tatouage ?” ou “Qu’est-ce qu’il représente ?”.
                    </br></br>
                    Le site permet aux personnes tatouées de raconter l’histoire de leur‧s
                    tatouage‧s, puis d’en discuter avec des visiteurs, comme une conversation
                    autour d’un verre.
                    </br></br>
                    C’est ce que reflète le logo du site.
                    </br></br>
                    <p class="m-0"><span class="text-danger">HOCHART</span> Alexandre</p>
                </div>
            </div>
            <div class="text-danger h4">Les <span class="text-body">5</span> dernières <span class="text-body">stories</span></div>
            <?php foreach ($story->fetchLastFiveStories() as $key => $value) { ?>
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
            <div class="text-danger h4 mt-5">Les <span class="text-body">5</span> derniers articles de <span class="text-body"><?= $siteName ?></span></div>
            <?php foreach ($feed->channel->item as $item) { ?>
                <div class="m-4 pr-1 storiesCards" onclick="window.open('<?= $item->link ?>');">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <img class="w-100" src="<?= getThumbnail() ?>" alt="Thumbnail" />
                        </div>
                        <div class="col-12 col-md-8 d-flex flex-column">
                            <div class="mt-2 font-weight-bold text-danger h5"><?= $item->title ?></div>
                            <div class="mt-1">Publié le <?= date_format(date_create($item->pubDate), "d/m/Y à H:i") ?></div>
                            <div class="my-auto text-break"><?= mb_substr($item->description, 0, 200) ?>...</div>
                        </div>
                    </div>
                </div>
            <?php if ($articlesCounter++ == 5) break;
            } ?>
        </div>
    </div>
    <?php require 'Views/footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/assets/scripts/loginUserModalScript.js"></script>
    <script src="/assets/scripts/indexScript.js"></script>
</body>

</html>