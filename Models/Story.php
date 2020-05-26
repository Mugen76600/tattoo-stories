<?php
class Story extends Database
{
    private $id;
    private $date;
    private $picture1;
    private $picture2;
    private $picture3;
    private $title;
    private $artist;
    private $text;
    private $id_users;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getPicture1()
    {
        return $this->picture1;
    }

    public function setPicture1($picture1)
    {
        $this->picture1 = $picture1;
    }

    public function getPicture2()
    {
        return $this->picture2;
    }

    public function setPicture2($picture2)
    {
        $this->picture2 = $picture2;
    }

    public function getPicture3()
    {
        return $this->picture3;
    }

    public function setPicture3($picture3)
    {
        $this->picture3 = $picture3;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getId_users()
    {
        return $this->id_users;
    }

    public function setId_users($id_users)
    {
        $this->id_users = $id_users;
    }

    // Méthode pour s'assurer de récupérer l'extension d'un fichier uploadé
    public function getFileExtension($inputName)
    {
        // Coupe la string à chaque point qu'elle contient et indexe chaque occurence dans un tableau
        $partialExtension = explode(".", basename($_FILES[$inputName]['name']));
        // Récupère le dernier index du tableau (correspondant à l'extension sans le point), et remplace le caractère 0 (devant la première lettre) par un point
        $fullExtension = substr_replace(end($partialExtension), ".", 0, 0);
        // Retourne l'extension complète
        return $fullExtension;
    }

    public function addStory()
    {
        $userId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : $_SESSION['userId'];
        $title = htmlspecialchars($this->firstCharUpper(trim($_POST['title'])));
        $artist = htmlspecialchars(trim($_POST['artist']));
        $date = date("Y-m-d G:i:s");
        $text = htmlspecialchars($this->firstCharUpper(trim($_POST['story'])));
        $picture1 = htmlspecialchars(trim($_POST['picture1']));
        $picture2 = htmlspecialchars(trim($_POST['picture2']));
        $picture3 = htmlspecialchars(trim($_POST['picture3']));
        $addStory = $this->pdo->prepare("INSERT INTO `ts_stories` (`date`, `picture1`, `picture2`, `picture3`, `title`, `artist`, `text`, `id_ts_users`) VALUES (:date, :picture1, :picture2, :picture3, :title, :artist, :text, :id_ts_users)");
        $addStory->execute(array(
            ":date" => $date,
            ":picture1" => $picture1,
            ":picture2" => $picture2,
            ":picture3" => $picture3,
            ":title" => $title,
            ":artist" => $artist,
            ":text" => $text,
            ":id_ts_users" => $userId
        ));
    }

    // Récupère les 5 dernières stories
    public function fetchLastFiveStories()
    {
        $fetchLastFiveStories = $this->pdo->prepare("SELECT `ts_stories`.`id`, DATE_FORMAT(`date`, '%d/%m/%Y à %H:%i'), `picture1`, `picture2`, `picture3`, `title`, `id_ts_users`, `login`, `text` FROM `ts_stories` INNER JOIN `ts_users` ON `id_ts_users` = `ts_users`.`id` ORDER BY `date` DESC LIMIT 5");
        $fetchLastFiveStories->execute();
        $result = $fetchLastFiveStories->fetchAll();
        return $result;
    }

    // Récupère toutes les stories
    public function fetchAllStories()
    {
        $fetchAllStories = $this->pdo->prepare("SELECT `ts_stories`.`id`, DATE_FORMAT(`date`, '%d/%m/%Y à %H:%i'), `picture1`, `picture2`, `picture3`, `title`, `id_ts_users`, `login`, `text` FROM `ts_stories` INNER JOIN `ts_users` ON `id_ts_users` = `ts_users`.`id` ORDER BY `date` DESC");
        $fetchAllStories->execute();
        $result = $fetchAllStories->fetchAll();
        return $result;
    }

    // Récupère les infos de la story sélectionnée
    public function detailsStory()
    {
        $storyId = $_GET['id'];
        $detailsStory = $this->pdo->prepare("SELECT `ts_stories`.`id`, DATE_FORMAT(`date`, '%d/%m/%Y à %H:%i'), `picture1`, `picture2`, `picture3`, `title`, `artist`, `text`, `id_ts_users`, `login` FROM `ts_stories` INNER JOIN `ts_users` ON `id_ts_users` = `ts_users`.`id` WHERE `ts_stories`.`id` = $storyId");
        $detailsStory->execute();
        $result = $detailsStory->fetchAll();
        return $result;
    }

    // Met à jour la story sélectionnée
    public function updateStory($pic1Value, $pic2Value, $pic3Value)
    {
        $storyId = $_GET['id'];
        $title = htmlspecialchars($this->firstCharUpper(trim($_POST['title'])));
        $artist = htmlspecialchars(trim($_POST['artist']));
        $date = date("Y-m-d G:i:s");
        $text = htmlspecialchars($this->firstCharUpper(trim($_POST['story'])));
        $picture1 = htmlspecialchars(trim($pic1Value));
        $picture2 = htmlspecialchars(trim($pic2Value));
        $picture3 = htmlspecialchars(trim($pic3Value));
        $addStory = $this->pdo->prepare("UPDATE `ts_stories` SET `date` = :date, `picture1` = :picture1, `picture2` = :picture2, `picture3` = :picture3, `title` = :title, `artist` = :artist, `text` = :text WHERE `id` = $storyId");
        $addStory->execute(array(
            ":date" => $date,
            ":picture1" => $picture1,
            ":picture2" => $picture2,
            ":picture3" => $picture3,
            ":title" => $title,
            ":artist" => $artist,
            ":text" => $text
        ));
    }

    // Récupère toutes les stories du user connecté
    public function listUserStories()
    {
        // Ternaires vérifiant comment l'utilisateur est loggé
        $isConnectedViaSession = isset($_SESSION['userId']) && $_SESSION['userId'] != "" ? true : false;
        $isConnectedViaCookie = isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" ? true : false;
        if ($isConnectedViaSession) {
            $session = $_SESSION['userId'];
            $listUserStories = $this->pdo->prepare("SELECT `ts_stories`.`id`, DATE_FORMAT(`date`, '%d/%m/%Y à %H:%i'), `picture1`, `picture2`, `picture3`, `title`, `id_ts_users`, `login`, `text` FROM `ts_stories` INNER JOIN `ts_users` ON `id_ts_users` = `ts_users`.`id` WHERE `id_ts_users` = $session ORDER BY `date` DESC");
            $listUserStories->execute();
            $result = $listUserStories->fetchAll();
            return $result;
        } else if ($isConnectedViaCookie) {
            $cookie = $_COOKIE['userId'];
            $listUserStories = $this->pdo->prepare("SELECT `ts_stories`.`id`, DATE_FORMAT(`date`, '%d/%m/%Y à %H:%i'), `picture1`, `picture2`, `picture3`, `title`, `id_ts_users`, `login`, `text` FROM `ts_stories` INNER JOIN `ts_users` ON `id_ts_users` = `ts_users`.`id` WHERE `id_ts_users` = $cookie ORDER BY `date` DESC");
            $listUserStories->execute();
            $result = $listUserStories->fetchAll();
            return $result;
        }
    }

    // Supprime la story sélectionnée
    public function deleteStory()
    {
        $pic1 = $_POST['pic1'];
        $pic2 = $_POST['pic2'];
        $pic3 = $_POST['pic3'];
        $storyId = $_POST['deleteStory'];
        // Suppression des images sur le hdd
        unlink(dirname(getcwd()) . $pic1);
        $pic2 != "" ? unlink(dirname(getcwd()) . $pic2) : "";
        $pic3 != "" ? unlink(dirname(getcwd()) . $pic3) : "";
        $deleteStory = $this->pdo->prepare("DELETE FROM `ts_stories` WHERE `id` = $storyId");
        $deleteStory->execute();
    }

    // Méthode de recherche par date, titre, login, artiste
    public function searchStory()
    {
        $search = htmlspecialchars(trim($_GET['query']));
        $searchStory = $this->pdo->prepare("SELECT `ts_stories`.`id`, DATE_FORMAT(`date`, '%d/%m/%Y à %H:%i'), `picture1`, `picture2`, `picture3`, `title`, `id_ts_users`, `login`, `text` FROM `ts_stories` INNER JOIN `ts_users` ON `id_ts_users` = `ts_users`.`id` WHERE DATE_FORMAT(`date`, '%d/%m/%Y à %H:%i') LIKE '%$search%' OR `title` LIKE '%$search%' OR `login` LIKE '%$search%' OR `artist` LIKE '%$search%' ORDER BY `date` DESC");
        $searchStory->execute();
        $result = $searchStory->fetchAll();
        return $result;
    }
}
