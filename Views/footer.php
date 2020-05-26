<?php
require 'modals.php';
require 'cookiesWarning.php';
?>
<div style="height:80px;"></div>
<footer class="text-center text-white pt-5">
    <div class="container my-5">
        <div class="row align-items-center">
            <div id="googleMaps" class="col-12 col-sm-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2592.025952394138!2d0.13147871511363374!3d49.48401676440599!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e02e55af007f11%3A0xcb679803210d6c5c!2s2%20Rue%20de%20Dombasle%2C%2076600%20Le%20Havre!5e0!3m2!1sfr!2sfr!4v1576165606190!5m2!1sfr!2sfr" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
            </div>
            <div class="col-12 col-sm-6">
                <p class="my-4"><a class="text-decoration-none text-white <?= $_SERVER['REQUEST_URI'] == "/index.php" || $_SERVER['REQUEST_URI'] == "/" ? "shadow p-2 border border-0 bg-white text-danger rounded" : ""; ?>" href="/index.php">Accueil</a></p>
                <p class="my-4"><a class="text-decoration-none text-white <?= strpos($_SERVER['REQUEST_URI'], "listStories") !== false || strpos($_SERVER['REQUEST_URI'], "detailsStory") !== false || strpos($_SERVER['REQUEST_URI'], "updateStory") !== false ? "shadow p-2 border border-0 bg-white text-danger rounded" : ""; ?>" href="/Views/listStories.php">Stories</a></p>
                <p class="my-4"><a class="text-decoration-none text-white <?= strpos($_SERVER['REQUEST_URI'], "rssFeed") !== false ? "shadow p-2 border border-0 bg-white text-danger rounded" : ""; ?>" href="/Views/rssFeed.php">Articles</a></p>
                <?php if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] != "" || isset($_COOKIE['userLogin'])) { ?>
                    <p class="my-4"><a class="text-decoration-none text-white <?= strpos($_SERVER['REQUEST_URI'], "accountUser") !== false ? "shadow p-2 border border-0 bg-white text-danger rounded" : ""; ?>" href="/Views/accountUser.php">Mon compte</a></p>
                    <p class="my-4"><a class="text-decoration-none text-white <?= strpos($_SERVER['REQUEST_URI'], "addStory") !== false ? "shadow p-2 border border-0 bg-white text-danger rounded" : ""; ?>" href="/Views/addStory.php">Écrire une STORY</a></p>
                <?php } else { ?>
                    <p class="my-4"><a class="text-decoration-none text-white <?= strpos($_SERVER['REQUEST_URI'], "addUser") !== false ? "shadow p-2 border border-0 bg-white text-danger rounded" : ""; ?>" href="/Views/addUser.php">Inscription</a></p>
                    <p class="my-4"><a class="text-decoration-none text-white" href="#" data-toggle="modal" data-target="#logModal">Connexion</a></p>
                <?php } ?>
            </div>
        </div>
    </div>
    <p class="lead">Tattoo Stories sur les réseaux :</p>
    <div class="d-flex justify-content-center mt-2 mb-4">
        <a href="#" class="text-white"><i class="fab fa-facebook-f mx-4"></i></a>
        <a href="#" class="text-white"><i class="fab fa-instagram mx-4"></i></a>
    </div>
    <span><small>©2020 HOCHART Alexandre |</small> <a class="text-decoration-none text-white" data-toggle="modal" data-target="#legalModal" href="#"><small>Mentions légales</small></a></span>
</footer>