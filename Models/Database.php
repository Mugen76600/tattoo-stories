<?php
class Database
{
    // Attribut
    protected $pdo;

    // L'attribut tente d'effectuer la connexion à la base de donnée ou renvoie une erreur en cas d'échec
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=tattoostories;charset=utf8", "root");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Equivaut à ucfirst() mais fonctionne avec les accents
    public function firstCharUpper($string, $encoding = 'UTF-8')
    {
        // Récupère la longueur de la string passée en paramètre
        $getStringLength = mb_strlen($string, $encoding);
        // Récupère le premier caractère de la string en paramètre
        $firstChar = mb_substr($string, 0, 1, $encoding);
        // Récupère le reste des caractères de la string en paramètre
        $remainingChars = mb_substr($string, 1, $getStringLength - 1, $encoding);
        // Passe le premier caractère en majuscule (avec accent) et concatène le reste. Retourne le résultat
        return mb_strtoupper($firstChar, $encoding) . $remainingChars;
    }
}
