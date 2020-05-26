<?php
require '../Controllers/rssFeedController.php';
require '../Controllers/loginUserController.php';
require '../Controllers/cookiesWarningController.php';
require 'bodyTop.php';
?>

<body>
    <?php require 'navbar.php' ?>
    <div class="container-fluid">
        <div class="container">
            <a class="text-decoration-none" data-toggle="collapse" href="#conceptText" role="button">
                <h1 class="display-1 mb-5 mt-2 text-danger">Les derniers articles de <span class="text-body"><?= $siteName ?></span></h1>
            </a>
            <div class="collapse mb-5" id="conceptText">
                <div class="card card-body border-danger">
                    InkedMag est un magazine de tatouage indépendant ayant une approche artistique de son contenu. Nous souhaitons créer de superbes shooting avec des tatoueurs et des personnes ayant des histoires intéressantes à raconter. Établie avec soin, la ligne éditoriale parle de tatouages par rapport à leur richesse culturelle et les modes actuelles. Ce magazine est destiné aux artistes, aux collectionneurs et à ceux et celles n'étant pas encore passés sous l'aiguille. Il permet au lecteur de découvrir de nouveaux artistes, produits et idées.
                    </br></br>
                    InkedMag est plus qu'un magazine, c'est un style de vie.
                </div>
            </div>
            <?php foreach ($feed->channel->item as $item) { ?>
                <div class="m-4 pr-1 storiesCards" onclick="window.open('<?= $item->link ?>');">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <img class="w-100" src="<?= getThumbnail() ?>" alt="Thumbnail" />
                        </div>
                        <div class="col-12 col-md-8 d-flex flex-column">
                            <div class="mt-2 font-weight-bold text-danger h5"><?= $item->title ?></div>
                            <div class="mt-1">Publié le <?= date_format(date_create($item->pubDate), "d/m/Y à H:i") ?></div>
                            <div class="my-auto"><?= mb_substr($item->description, 0, 200) ?>...</div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php require 'footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/assets/scripts/loginUserModalScript.js"></script>
    <script src="/assets/scripts/rssFeedScript.js"></script>
</body>

</html>