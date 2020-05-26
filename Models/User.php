<?php
class User extends Database
{
    private $id;
    private $lastname;
    private $firstname;
    private $mail;
    private $login;
    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function checkMailAvailibility()
    {
        $search = htmlspecialchars($_POST['mail']);
        $checkMail = $this->pdo->prepare("SELECT `mail` FROM `ts_users` WHERE `mail` LIKE '%$search%'");
        $checkMail->execute();
        $result = $checkMail->fetch();
        return $result;
    }

    public function checkPseudoAvailibility()
    {
        $search = htmlspecialchars($_POST['login']);
        // Préparation de la requête
        $checkPseudo = $this->pdo->prepare("SELECT `login` FROM `ts_users` WHERE `login` LIKE '$search'");
        // Exécution de la requête
        $checkPseudo->execute();
        // Récupération des données trouvées par la requête
        $result = $checkPseudo->fetch();
        return $result;
    }

    public function addUser()
    {
        // Formattage et sécurisation des données avant l'envoi en base de donnée
        $lastname = htmlspecialchars(mb_strtoupper(trim($_POST['lastname'])));
        $firstname = htmlspecialchars($this->firstCharUpper(trim($_POST['firstname'])));
        $mail = htmlspecialchars(trim($_POST['mail']));
        $login = htmlspecialchars(trim($_POST['login']));
        $password = htmlspecialchars(password_hash(trim($_POST['password']), PASSWORD_DEFAULT));
        // Préparation de la requête
        $addUser = $this->pdo->prepare("INSERT INTO `ts_users` (`lastname`, `firstname`, `mail`, `login`, `password`) VALUES (:lastname, :firstname, :mail, :login, :password)");
        // Exécution de la requête
        $addUser->execute(array(
            ":lastname" => $lastname,
            ":firstname" => $firstname,
            ":mail" => $mail,
            ":login" => $login,
            ":password" => $password
        ));
    }

    // Récupération de la table user pour les vérifier lors du login
    public function getAllUsers()
    {
        $login = $_POST['modalLogin'];
        $getAllUsers = $this->pdo->prepare("SELECT `mail`, `login`, `password`, `firstname`, `lastname`, `id` FROM `ts_users` WHERE `mail` LIKE '$login' OR `login` LIKE '$login'");
        $getAllUsers->execute();
        $result = $getAllUsers->fetchAll();
        return $result;
    }

    // Retourne true si le combo login/password users est bon, sinon retourne null
    public function checkUsers()
    {
        $login = $_POST['modalLogin'];
        $password = $_POST['modalPassword'];
        foreach ($this->getAllUsers() as $key => $value) {
            if ($login == $value[0] && password_verify($password, $value[2]) || $login == $value[1] && password_verify($password, $value[2])) {
                $check = true;
                $this->setMail($value[0]);
                $this->setLogin($value[1]);
                $this->setFirstname($value[3]);
                $this->setLastname($value[4]);
                $this->setId($value[5]);
            } else {
                $check = false;
            }
            if ($check) {
                return $check;
            }
        }
    }

    // Récupération des infos du user connecté pour update
    public function getInfoUserForUpdate()
    {
        // Ternaires vérifiant comment l'utilisateur est loggé
        $isConnectedViaSession = isset($_SESSION['userId']) && $_SESSION['userId'] != "" ? true : false;
        $isConnectedViaCookie = isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" ? true : false;
        if ($isConnectedViaCookie) {
            $id = $_COOKIE['userId'];
            $getInfoUserForUpdate = $this->pdo->prepare("SELECT * FROM `ts_users` WHERE `id` = $id");
            $getInfoUserForUpdate->execute();
            $result = $getInfoUserForUpdate->fetchAll();
            return $result;
        } else if ($isConnectedViaSession) {
            $id = $_SESSION['userId'];
            $getInfoUserForUpdate = $this->pdo->prepare("SELECT * FROM `ts_users` WHERE `id` = $id");
            $getInfoUserForUpdate->execute();
            $result = $getInfoUserForUpdate->fetchAll();
            return $result;
        }
    }

    public function updateUser($withOrWithoutPassword)
    {
        $isConnectedViaSession = isset($_SESSION['userId']) && $_SESSION['userId'] != "" ? true : false;
        $isConnectedViaCookie = isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" ? true : false;
        // Formattage et sécurisation des données avant l'envoi en base de donnée
        $lastname = htmlspecialchars(mb_strtoupper(trim($_POST['lastname'])));
        $firstname = htmlspecialchars($this->firstCharUpper(trim($_POST['firstname'])));
        $mail = htmlspecialchars(trim($_POST['mail']));
        $login = htmlspecialchars(trim($_POST['login']));
        if ($isConnectedViaCookie) {
            $id = $_COOKIE['userId'];
            if ($withOrWithoutPassword == "withPassword") {
                $password = htmlspecialchars(password_hash(trim($_POST['newPassword']), PASSWORD_DEFAULT));
                $updateUser = $this->pdo->prepare("UPDATE `ts_users` SET `firstname` = :firstname, `lastname` = :lastname, `mail` = :mail, `login` = :login, `password` = :password WHERE `id` = $id");
                $updateUser->execute(array(
                    ":firstname" => $firstname,
                    ":lastname" => $lastname,
                    ":mail" => $mail,
                    ":login" => $login,
                    ":password" => $password
                ));
            } else if ($withOrWithoutPassword == "withoutPassword") {
                $updateUser = $this->pdo->prepare("UPDATE `ts_users` SET `firstname` = :firstname, `lastname` = :lastname, `mail` = :mail, `login` = :login WHERE `id` = $id");
                $updateUser->execute(array(
                    ":firstname" => $firstname,
                    ":lastname" => $lastname,
                    ":mail" => $mail,
                    ":login" => $login
                ));
            }
            setcookie('userLogin', $login, time() + 60 * 60 * 24 * 30, '/');
            setcookie('userMail', $mail, time() + 60 * 60 * 24 * 30, '/');
            setcookie('userLastname', $lastname, time() + 60 * 60 * 24 * 30, '/');
            setcookie('userFirstname', $firstname, time() + 60 * 60 * 24 * 30, '/');
        } else if ($isConnectedViaSession) {
            $id = $_SESSION['userId'];
            if ($withOrWithoutPassword == "withPassword") {
                $password = htmlspecialchars(password_hash(trim($_POST['newPassword']), PASSWORD_DEFAULT));
                $updateUser = $this->pdo->prepare("UPDATE `ts_users` SET `firstname` = :firstname, `lastname` = :lastname, `mail` = :mail, `login` = :login, `password` = :password WHERE `id` = $id");
                $updateUser->execute(array(
                    ":firstname" => $firstname,
                    ":lastname" => $lastname,
                    ":mail" => $mail,
                    ":login" => $login,
                    ":password" => $password
                ));
            } else if ($withOrWithoutPassword == "withoutPassword") {
                $updateUser = $this->pdo->prepare("UPDATE `ts_users` SET `firstname` = :firstname, `lastname` = :lastname, `mail` = :mail, `login` = :login WHERE `id` = $id");
                $updateUser->execute(array(
                    ":firstname" => $firstname,
                    ":lastname" => $lastname,
                    ":mail" => $mail,
                    ":login" => $login
                ));
            }
            $_SESSION['userLogin'] = $login;
            $_SESSION['userMail'] = $mail;
            $_SESSION['userLastname'] = $lastname;
            $_SESSION['userFirstname'] = $firstname;
        }
    }

    public function deleteUser()
    {
        $isConnectedViaSession = isset($_SESSION['userId']) && $_SESSION['userId'] != "" ? true : false;
        $isConnectedViaCookie = isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" ? true : false;
        if ($isConnectedViaCookie) {
            $id = $_COOKIE['userId'];
            $deleteUser = $this->pdo->prepare("DELETE FROM `ts_users` WHERE `id` = $id");
            $deleteUser->execute();
        } else if ($isConnectedViaSession) {
            $id = $_SESSION['userId'];
            $deleteUser = $this->pdo->prepare("DELETE FROM `ts_users` WHERE `id` = $id");
            $deleteUser->execute();
        }
    }
}
