<div style="height: 80px;">
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand" href="/index.php">
            <img src="/assets/img/logo.png" width="50" height="50" class="d-inline-block align-middle" alt="Logo" />
            <span class="text-danger">TATTOO</span> Stories
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarButtons" aria-controls="navbarButtons" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarButtons">
            <?php if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] != "") { ?>
                <span class="navbar-text mr-1">
                    Bienvenue <span class="text-danger"><?= $_SESSION['userLogin'] ?></span>
                </span>
                <i class="fas fa-heart mr-3"></i>
            <?php } else if (isset($_COOKIE['userLogin']) && $_COOKIE['userLogin'] != "") { ?>
                <span class="navbar-text mr-1">
                    Bienvenue <span class="text-danger"><?= $_COOKIE['userLogin'] ?></span>
                </span>
                <i class="fas fa-heart mr-3"></i>
            <?php } ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $_SERVER['REQUEST_URI'] == "/index.php" || $_SERVER['REQUEST_URI'] == "/" ? "shadow active border border-0 rounded bg-danger text-white" : ""; ?>" href="/index.php"><span>Accueil</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], "listStories") !== false || strpos($_SERVER['REQUEST_URI'], "detailsStory") !== false || strpos($_SERVER['REQUEST_URI'], "updateStory") !== false ? "shadow active border border-0 rounded bg-danger text-white" : ""; ?>" href="/Views/listStories.php"><span>Stories</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], "rssFeed") !== false ? "shadow active border border-0 rounded bg-danger text-white" : ""; ?>" href="/Views/rssFeed.php"><span>Articles</span></a>
                </li>
                <?php if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] != "" || isset($_COOKIE['userLogin'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], "accountUser") !== false ? "shadow active border border-0 rounded bg-danger text-white" : ""; ?>" href="/Views/accountUser.php"><span>Mon compte</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], "addStory") !== false ? "shadow active border border-0 rounded bg-danger text-white" : "text-danger"; ?>" href="/Views/addStory.php"><span>Écrire une STORY</span></a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], "addUser") !== false ? "shadow active border border-0 rounded bg-danger text-white" : ""; ?>" href="/Views/addUser.php"><span>Inscription</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link loginButton" data-toggle="modal" data-target="#logModal"><span>Connexion</span></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</div>