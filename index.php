<?php session_start();
// On utilise le controller xxxController qui se trouve dans le fichier portant 
// le mème nom: controller/CinemaController.php (placement physique)
use Controller\CinemaController;
use Controller\FilmController;
use Controller\GenresController;
use Controller\RealisateurController;
use Controller\ActeurController;
use Controller\CastingController;
use Controller\PersonneController;


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
$ctrlPersonne = new PersonneController();


$id= (isset($_GET["id"])) ? filter_input(INPUT_GET, "id", FILTER_DEFAULT) : null;

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
    
        // créer / supprimer film
        case "creerFilm": $ctrlFilm->creerFilmForm();break;
        case "creationFilm": $ctrlFilm->creationFilm();break; 
        case "supprimerFilm": $ctrlFilm->supprimerFilm();break; 
    
        // films Realisateur
        case "ajouterFilmRea": $ctrlRea->ajouterFilmRea($id);break;
        case "supprimerFilmRea": $ctrlRea->supprimerFilmRea($id);break;
    
        // créer personne
        case "creerFormActeur": $ctrlPersonne->creerFormPersonne("acteur");break;
        case "creerFormRealisateur": $ctrlPersonne->creerFormPersonne("realisateur");break;  
        case "creerPersonne": $ctrlPersonne->creerPersonne();break;
    
        // supprimer personne
        case "supprimerActeur": $ctrlActeur->supprimerActeur();break;
        case "supprimerRealisateur": $ctrlRea->supprimerRealisateur();break;

        // genre
        case "ajouterGenre": $ctrlGenre->ajouterGenre();break;
        case "supprimerGenre": $ctrlGenre->supprimerGenre();break;

        // genre film
        case "ajouterGenreFilm": $ctrlGenre->ajouterGenreFilm($id);break;
        case "supprimerGenreFilm": $ctrlGenre->supprimerGenreFilm($id);break;
        
        // supprimer casting
        case "supprimerCastingFilm": $ctrlCasting->supprimerCastingFilm($id);break;
        case "supprimerCastingActeur": $ctrlCasting->supprimerCastingActeur($id);break;
      
        // créer casting
        case "creerCastingFilm": $ctrlCasting->creerCastingFilm($id);break;
        case "creerCastingActeur": $ctrlCasting->creerCastingActeur($id);break;
        
        // modif personne
        case "modifActeurForm": $ctrlPersonne->modifPersonneForm($id, "acteur");break;
        case "modifRealisateurForm": $ctrlPersonne->modifPersonneForm($id, "realisateur");break;
        case "modifPersonne": $ctrlPersonne->modifPersonne($id);break;

        // modifFilm
        case "modifFilmForm": $ctrlFilm->modifFilmForm($id);break;
        case "modifFilm": $ctrlFilm->modifFilm($id);break;

      
        default: $ctrlCinema->Accueil();
    }
}   else {
    $ctrlCinema->Accueil();

}