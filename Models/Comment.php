<?php
// La classe est une sous-classe (enfant) de la classe Database et hérite des attributs de Database
class Comment extends Database
{
    private $id;
    private $date;
    private $title;
    private $text;
    private $id_ts_users;
    private $id_ts_stories;

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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getId_ts_users()
    {
        return $this->id_ts_users;
    }

    public function setId_ts_users($id_ts_users)
    {
        $this->id_ts_users = $id_ts_users;
    }

    public function getId_ts_stories()
    {
        return $this->id_ts_stories;
    }

    public function setId_ts_stories($id_ts_stories)
    {
        $this->id_ts_stories = $id_ts_stories;
    }

    public function addComment()
    {
        // Ternaires vérifiant comment l'utilisateur est loggé
        $isConnectedViaSession = isset($_SESSION['userId']) && $_SESSION['userId'] != "" ? true : false;
        $isConnectedViaCookie = isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" ? true : false;
        // Formatage et sécurisation des données pour l'envoi en bdd
        $date = date("Y-m-d G:i:s");
        $title = htmlspecialchars($this->firstCharUpper(trim($_POST['title'])));
        $text = htmlspecialchars($this->firstCharUpper(trim($_POST['text'])));
        $storyId = $_GET['id'];
        if ($isConnectedViaCookie) {
            $userId = $_COOKIE['userId'];
            // Préparation de la requête d'insertion en bdd
            $addComment = $this->pdo->prepare("INSERT INTO `ts_comments` (`date`, `title`, `text`, `id_ts_users`, `id_ts_stories`) VALUES (:date, :title, :text, :id_ts_users, :id_ts_stories)");
            // Envoi des données en bdd
            $addComment->execute(array(
                ":date" => $date,
                ":title" => $title,
                ":text" => $text,
                ":id_ts_users" => $userId,
                ":id_ts_stories" => $storyId
            ));
        } else if ($isConnectedViaSession) {
            $userId = $_SESSION['userId'];
            $addComment = $this->pdo->prepare("INSERT INTO `ts_comments` (`date`, `title`, `text`, `id_ts_users`, `id_ts_stories`) VALUES (:date, :title, :text, :id_ts_users, :id_ts_stories)");
            $addComment->execute(array(
                ":date" => $date,
                ":title" => $title,
                ":text" => $text,
                ":id_ts_users" => $userId,
                ":id_ts_stories" => $storyId
            ));
        }
    }

    public function checkNumberOfCommentsInStory()
    {
        $storyId = $_GET['id'];
        // Préparation de la requête d'affichage
        $checkNumberOfCommentsInStory = $this->pdo->prepare("SELECT COUNT(*) FROM `ts_comments` WHERE `id_ts_stories` = $storyId");
        // Exécution de la requête
        $checkNumberOfCommentsInStory->execute();
        // Récupération des données retournées par la requête
        $result = $checkNumberOfCommentsInStory->fetchAll();
        return $result;
    }

    public function showComments()
    {
        $storyId = $_GET['id'];
        $showComments = $this->pdo->prepare("SELECT DATE_FORMAT(`date`, '%d/%m/%Y à %H:%i'), `title`, `text`, `login`, `date`, `id_ts_users`, `ts_comments`.`id` FROM `ts_comments` INNER JOIN `ts_users` ON `id_ts_users` = `ts_users`.`id` WHERE $storyId = `id_ts_stories` ORDER BY `date`");
        $showComments->execute();
        $result = $showComments->fetchAll();
        return $result;
    }

    public function updateComment()
    {
        // Utilisation d'une méthode créée précédemment pour stocker l'id du commentaire dans une variable
        foreach ($this->showComments() as $key => $value) {
            $commentId = $value[6];
        }
        $isConnectedViaSession = isset($_SESSION['userId']) && $_SESSION['userId'] != "" ? true : false;
        $isConnectedViaCookie = isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" ? true : false;
        $storyId = $_GET['id'];
        $date = date("Y-m-d G:i:s");
        $title = htmlspecialchars($this->firstCharUpper(trim($_POST['updatedCommentTitle'])));
        $text = htmlspecialchars($this->firstCharUpper(trim($_POST['updatedCommentText'])));
        if ($isConnectedViaSession) {
            $userId = $_SESSION['userId'];
            // Préparation de la requête de mise à jour de la table 'comment'
            $updateComment = $this->pdo->prepare("UPDATE `ts_comments` SET `date` = :date, `title` = :title, `text` = :text WHERE `id_ts_stories` = $storyId AND `id_ts_users` = $userId AND `id` = $commentId");
            $updateComment->execute(array(
                ":date" => $date,
                ":title" => $title,
                ":text" => $text
            ));
        } else if ($isConnectedViaCookie) {
            $userId = $_COOKIE['userId'];
            $updateComment = $this->pdo->prepare("UPDATE `ts_comments` SET `date` = :date, `title` = :title, `text` = :text WHERE `id_ts_stories` = $storyId AND `id_ts_users` = $userId");
            $updateComment->execute(array(
                ":date" => $date,
                ":title" => $title,
                ":text" => $text
            ));
        }
    }

    public function deleteComment()
    {
        foreach ($this->showComments() as $key => $value) {
            $commentId = $value[6];
        }
        $isConnectedViaSession = isset($_SESSION['userId']) && $_SESSION['userId'] != "" ? true : false;
        $isConnectedViaCookie = isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" ? true : false;
        $storyId = $_GET['id'];
        if ($isConnectedViaCookie) {
            $userId = $_COOKIE['userId'];
            // Préparation de la suppression
            $deleteComment = $this->pdo->prepare("DELETE FROM `ts_comments` WHERE `id_ts_stories` = $storyId AND `id_ts_users` = $userId AND `id` = $commentId");
            $deleteComment->execute();
        } else if ($isConnectedViaSession) {
            $userId = $_SESSION['userId'];
            $deleteComment = $this->pdo->prepare("DELETE FROM `ts_comments` WHERE `id_ts_stories` = $storyId AND `id_ts_users` = $userId AND `id` = $commentId");
            $deleteComment->execute();
        }
    }
}
