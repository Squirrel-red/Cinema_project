<?php

namespace Controller;
use Model\Connect;

class CinemaController {



/* ----------------------------------------  --------------------------------------------------- */
// Liste Films
    public function listFilms() {
        $sql = "
            SELECT titre, date_sortie, affiche_film, film.id_film AS id
            FROM film
            ";

        $pdo = Connect::seConnecter();
        $requete = $pdo->query($sql);

    
        //{
        //        INNER JOIN gestion_genre
        //         ON film.id_film = gestion_genre.id_film
        //         INNER JOIN genre
        //         ON gestion_genre.id_genre = genre.id_genre
        //         WHERE genre.genre = "'.$genre.'"';
        //}
        //if($filtre != "defaut")
        //{
        //     $requete .= "ORDER BY ".$filtre." DESC";
        //}
        require "view\listFilms.php";
    }

    // Liste de tous les genres de films
    public function listGenres(){
        $sql = "
            SELECT id_genre AS id, genre
            FROM genre
            ";

        $pdo = Connect::seConnecter();
        $requete = $pdo->query($sql);

        require "view\listGenres.php";
    } 

    // Liste Realisateurs
    public function listRealisateurs() {
        $sql = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, personne.profil AS profil, realisateur.id_realisateur AS id
            FROM personne, realisateur
            WHERE personne.id_personne = realisateur.id_personne
            ";

        $pdo = Connect::seConnecter();
        $requete = $pdo->query($sql);

        require "view\listRealisateurs.php";
    }

// Liste Acteurs
    public function listActeurs() {
        $sql = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, acteur.id_personne AS id, profil
            FROM acteur, personne
            WHERE acteur.id_personne = personne.id_personne
            ";

        $pdo = Connect::seConnecter();
        $requete = $pdo->query($sql);

        require "view\listActeurs.php";
    }

// Liste Personnes
    public function listPersonnes(){
        $sql = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, id_personne AS id
            FROM personne
            ";

        $pdo = Connect::seConnecter();
        $requete = $pdo->query($sql);
         
        require "view\listPersonnes.php";
    }


// Liste Acteurs par film
    public function listActeursAndRoleParFilm() {
        $sql = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, profil, acteur.id_personne AS id, role.nom_personnage AS personnage, film.titre
            FROM personne, role, acteur, contrat, film
            WHERE personne.id_personne = acteur.id_personne
            AND
            contrat.id_acteur = acteur.id_acteur
            AND 
            contrat.id_role = role.id_role
            AND
            contrat.id_film = film.id_film          
            ";

             $pdo = Connect::seConnecter();
             $requete = $pdo->query($sql);
     
             require "view\listActeursAndRoleParFilm.php";
    }




}
