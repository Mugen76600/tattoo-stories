<?php
session_start();
date_default_timezone_set("Europe/Paris");
require 'Models/Database.php';
require 'Models/Story.php';
require 'Models/User.php';
$story = new Story();
// Récupération des informations du flux rss
$feed = simplexml_load_file("https://www.inkedmag.com/.rss/full/");
$siteName = $feed->channel->title;
// Instanciation d'un compteur pour limiter le nombre d'articles à afficher
$articlesCounter = 1;
// Récupère une image aléatoire sur un site fournissant des images via son url
function getThumbnail()
{
    // Tant que l'url de l'image retourne une erreur, la fonction cherche une nouvelle image
    do {
        // Champs de recherche de la fonction
        $picId = mt_rand(1, 1064);
        $url = "https://i.picsum.photos/id/" . $picId . "/1920/1080.jpg";
        // Récupération du code renvoyé par l'url
        $headers = get_headers($url);
        // La recherche d'id se poursuit tant que la page retourne un code erreur 404
    } while ($headers && strpos($headers[0], '404'));
    // Si la page existe, la fonction retourne l'url de l'image
    return "https://i.picsum.photos/id/" . $picId . "/1920/1080.jpg";
}
