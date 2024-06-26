<?php

namespace Controller;
use Model\Connect;

class CinemaController {



// Affichage de la page d'ACCUEIL //

public function Accueil() {
    $pdo = Connect::seConnecter();
    // infos film favori
    $requeteFilmFavori = $pdo->query("
    SELECT *, CONCAT(p.nom, ' ', p.prenom) AS rea
    FROM film
    INNER JOIN realisateur r ON film.id_realisateur = r.id_realisateur
    INNER JOIN personne p ON r.id_personne = p.id_personne
    WHERE id_film = 2
    ");

    // acteurs du film favori
    $requeteActeursFilmFav = $pdo->query("
    SELECT acteur.id_acteur, nom, prenom, CONCAT(nom, ' ', prenom) AS fullName, photo, COUNT(*) AS nbFilms
    FROM acteur
    INNER JOIN personne p ON p.id_personne = acteur.id_personne
    INNER JOIN casting ON casting.id_acteur = acteur.id_acteur
    WHERE casting.id_film = 2
    GROUP BY acteur.id_acteur
    ORDER BY nbFilms DESC
    ");

    // infos des films du moment
    $requeteFilmsMoment = $pdo->query("
    SELECT *
    FROM film
    ORDER BY date_sortie DESC
    LIMIT 2
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
    LIMIT 2
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

}
