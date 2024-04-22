<?php

namespace Controller;
use Model\Connect;

class CinemaController {



/* --------------- VIEW DE LA PAGE D'ACCUEIL--------------------------------- */
public function Accueil() {
    $pdo = Connect::seConnecter();
    // infos film favori
    $requeteFilmFavori = $pdo->query("
    SELECT *, CONCAT(p.nom, ' ', p.prenom) AS rea
    FROM film
    INNER JOIN realisateur r ON film.id_realisateur = r.id_realisateur
    INNER JOIN personne p ON r.id_personne = p.id_personne
    WHERE id_film = 9
    ");

    // acteurs du film favori
    $requeteActeursFilmFav = $pdo->query("
    SELECT acteur.id_acteur, nom, prenom, CONCAT(nom, ' ', prenom) AS fullName, COUNT(*) AS nbFilms
    FROM acteur
    INNER JOIN personne p ON p.id_personne = acteur.id_personne
    INNER JOIN casting ON casting.id_acteur = acteur.id_acteur
    WHERE casting.id_film = 9
    GROUP BY acteur.id_acteur
    ORDER BY nbFilms DESC
    ");

    // infos des films du moment
    $requeteFilmsMoment = $pdo->query("
    SELECT *
    FROM film
    ORDER BY date_sortie DESC
    ");
        // liste des genres " ' " préférés " ' "

    // liste films d'action
    $requeteAction = $pdo->query("
    SELECT *
    FROM film
    INNER JOIN gestion_genre g ON g.id_film = film.id_film
    INNER JOIN genre ON g.id_genre = genre.id_genre
    WHERE genre.id_genre = '1'
    ORDER BY date_sortie DESC
    ");

    // liste films pour toute la famille (genre "Comedie")
    $requeteFamille = $pdo->query("
    SELECT *
    FROM film f
    INNER JOIN gestion_genre g ON f.id_film = g.id_film
    INNER JOIN genre ON g.id_genre = genre.id_genre
    WHERE genre.id_genre = '3'
    ORDER BY date_sortie DESC
    ");

    // liste films de science-fiction
    $requeteSF = $pdo->query("
    SELECT *
    FROM film f
    INNER JOIN gestion_genre g ON f.id_film = g.id_film
    INNER JOIN genre ON g.id_genre = genre.id_genre
    WHERE genre.id_genre = '4'
    ORDER BY date_sortie DESC
    ");

    require "view/Accueil.php";
}

//------------------------------------------ 

// Liste Films
public function listFilms() {
        $sql = "
            SELECT nom_film AS titre, date_sortie, affiche_film, film.id_film AS id
            FROM film
            ";

        $pdo = Connect::seConnecter();
        $requete = $pdo->query($sql);


        require "view\listFilms.php";
}

// Liste de tous les genres de films
public function listGenres(){
        $sql = "
            SELECT id_genre AS id, nom_genre as genre
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
            SELECT CONCAT(nom, ' ',prenom) AS personne, profil, acteur.id_personne AS id, role.nom_role AS personnage, film.nom_film
            FROM personne, role, acteur, casting, film
            WHERE personne.id_personne = acteur.id_personne
            AND
            casting.id_acteur = acteur.id_acteur
            AND 
            casting.id_role = role.id_role
            AND
            casting.id_film = film.id_film          
            ";

        $pdo = Connect::seConnecter();
        $requete = $pdo->query($sql);
     
        require "view\listActeursAndRoleParFilm.php";
}

// Liste Films par genre
public function listFilmParGenre() {
        $sql = "
            SELECT film.nom_film AS titre, film.date_sortie AS date, genre.nom_genre AS genre
            FROM film, gestion_genre, genre
            WHERE film.id_film = gestion_genre.id_film
            AND
            gestion_genre.id_genre = genre.id_genre       
            ";

        $pdo = Connect::seConnecter();
        $requete = $pdo->query($sql);
 
        require "view\listFilmParGenre.php";
}


}
