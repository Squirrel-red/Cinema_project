<?php session_start();
// On utilise le controller xxxController qui se trouve dans le fichier portant 
// le mème nom: controller/CinemaController.php (placement physique)
use Controller\CinemaController;
use Controller\FilmController;
use Controller\GenresController;
use Controller\RealisateurController;
use Controller\ActeurController;
use Controller\CastingController;
//use Controller\PersonneController;


// On autocharge l'ensemble des classes du projet
spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

// On instancie xxxController
$ctrlCinema = new CinemaController();
$ctrlFilm = new FilmController();
$ctrlGenre = new GenresController();
$ctrlRea = new RealisateurController();
$ctrlActeur = new ActeurController();
$ctrlCasting = new CastingController();
//$ctrlPersonne = new PersonneController();

$id= ($_GET["id"]) ;

// En fonction de l'action détéctée dans l'URL via la propriété "action"
// on interagit avec la bonne méthode du controller
// $_GET['action'].........
if(isset($_GET["action"])){
    switch ($_GET["action"]) {

        // VIEW
        case "accueil"                   : $ctrlCinema->Accueil();break;

        case "listFilms"                 : $ctrlFilm->listFilms(); break;
        case "detailFilm"                : $ctrlFilm->detailFilm($id);break;

        case "listRealisateurs"          : $ctrlRea->listRealisateurs(); break;
        case "detailRealisateur"         : $ctrlRea->detailRealisateur($id); break;

        case "listActeurs"               : $ctrlActeur->listActeurs(); break;
        case "detailActeur"              : $ctrlActeur->detailActeur($id);break;

        case "listGenres"                : $ctrlGenre->listGenres(); break;
        case "filmsGenre"                : $ctrlGenre->filmsGenre($id); break; 

    //  case "listPersonnes"             : $ctrlCinema->listPersonnes(); break;
    

    // cases (créer, ajouter, modifier, supprimer)
        
        // supprimer casting
        case "supprimerCastingFilm": $ctrlCasting->supprimerCastingFilm($id);break;
        case "supprimerCastingActeur": $ctrlCasting->supprimerCastingActeur($id);break;
      
        // créer casting
        case "creerCastingFilm": $ctrlCasting->creerCastingFilm($id);break;
        case "creerCastingActeur": $ctrlCasting->creerCastingActeur($id);break;  

        default: $ctrlCinema->Accueil();
    }
}   else {
    $ctrlCinema->Accueil();

}