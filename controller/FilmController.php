<?php

namespace Controller;
use Model\Connect;

class FilmController {

  // VIEW DE LA PAGE listFilms //
  public function listFilms() {
    $pdo = Connect::seConnecter();
    $requete = $pdo->query("
    SELECT *, date_sortie AS annee_sortie
    FROM film
    ORDER BY date_sortie DESC
    ");

    require "view/listFilms.php";
  }


  // VIEW DE LA PAGE detailFilm //
  public function detailFilm($id) {
    $pdo = Connect::seConnecter();

    // LEFT JOIN pour éviter les pb à cause de la non-existance d'un realisateur
    $requeteFilm = $pdo->prepare('
      SELECT *, duree, CONCAT(p.prenom, " ", p.nom) AS rea, date_sortie
      FROM film
      LEFT JOIN realisateur r ON r.id_realisateur = film.id_realisateur
      LEFT JOIN personne p ON p.id_personne = r.id_personne
      WHERE film.id_film = :id
      ');

    $requeteFilm->execute(["id" => $id]);

    // requete des genres du film
    $requeteGenres = $pdo->prepare("
      SELECT *
      FROM gestion_genre g
      INNER JOIN film ON film.id_film = g.id_film
      INNER JOIN genre ON genre.id_genre = g.id_genre
      WHERE film.id_film = :id
      ORDER BY nom_genre
      ");
    $requeteGenres->execute(["id" => $id]);


    // requete des castings des acteurs
    $requeteActeurs = $pdo->prepare("
    SELECT *, CONCAT(prenom, ' ', nom) AS fullName
    FROM casting c 
    INNER JOIN acteur a ON c.id_acteur = a.id_acteur
    INNER JOIN personne p ON p.id_personne = a.id_personne
    INNER JOIN film ON c.id_film = film.id_film
    INNER JOIN role ON role.id_role = c.id_role
    WHERE film.id_film = :id
    ORDER BY nom
    ");
    $requeteActeurs->execute(["id" => $id]);

    $requeteActeursAll = $pdo->query("
    SELECT id_acteur, CONCAT(prenom, ' ', nom) AS fullName
    FROM acteur
    INNER JOIN personne p ON p.id_personne = acteur.id_personne 
    ");

    require "view/detailFilm.php";
  }
  
  // créer du film //
  
  // supprimer un film //

  // modifier un film //

  // mettre à jour d'un film //
  
}