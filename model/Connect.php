<?php
// dans ce fichier Connect.php on se contente de déclarer la connexion à la base de données

// namespace permet de catégoriser virtuellement (dans un espace de nom de la classe en question)
namespace Model;

// Classe abstraite car on va pas l'instancier, on utilisera seulement la méthode "se Connecter"
abstract class Connect{

    const HOST  = "localhost";
    const DB    = "cinema_project";
    const USER  = "root";
    const PASS  = "";

    public static function seConnecter() {
        try 
        {
            // "\" devant PDO sindique au framework que PDO est une classe native et non du projet
            return new \PDO("mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8", self::USER, self::PASS);
        }
        catch (\PDOException $ex) 
        {
            return $ex->getMessage();
        }
    }

}