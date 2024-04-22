<?php
// On utilise le controller CinemaController qui se trouve dans le fichier portant 
// le mème nom: controller/CinemaController.php (placement physique)
use Controller\CinemaController;

// On autocharge l'ensemble des classes du projet
spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

// On instancie CinemaController
$ctrlCinema = new CinemaController();

// En fonction de l'action détéctée dans l'URL via la propriété "action"
// on interagit avec la bonne méthode du controller
// $_GET['action'].........
if(isset($_GET["action"])){
    switch ($_GET["action"]) {
        case "accueil"                   : $ctrlCinema->Accueil();break;
        case "listFilms"                 : $ctrlCinema->listFilms(); break;
        case "listGenres"                : $ctrlCinema->listGenres(); break;
        case "listRealisateurs"          : $ctrlCinema->listRealisateurs(); break;
        case "listActeurs"               : $ctrlCinema->listActeurs(); break;
        case "listPersonnes"             : $ctrlCinema->listPersonnes(); break;
        case "listActeursAndRoleParFilm" : $ctrlCinema->listActeursAndRoleParFilm(); break;
        case "listFilmParGenre"          : $ctrlCinema->listFilmParGenre(); break;         

    }
}