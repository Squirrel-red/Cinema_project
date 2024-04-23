<?php

namespace Controller;
use Model\Connect;

class GenresController {

// View ListGenres //
  public function listGenres() {
    $pdo = Connect::seConnecter();

    $requeteGenres = $pdo->query("
    SELECT * FROM genre
    ORDER BY nom_genre
    ");
    require "view/listGenres.php";
  }
  
// View FilmsGenre //

// Liste des Films d'un genre
  public function filmsGenre($id) {
    $pdo = Connect::seConnecter();

    $requeteGenre = $pdo->prepare("
      SELECT *
      FROM genre
      WHERE id_genre = :id
      ");
    $requeteGenre->execute(["id" => $id]);

    $requeteFilmsGenre = $pdo->prepare("
      SELECT * 
      FROM genre
      INNER JOIN gestion_genre g ON g.id_genre = genre.id_genre
      INNER JOIN film ON film.id_film = g.id_film
      WHERE genre.id_genre = :id
      ORDER BY date_sortie DESC
      ");
    $requeteFilmsGenre->execute(["id" => $id]);

    // Liste des films qui ne sont pas dans le genre
    $requeteOtherFilms = $pdo->prepare("
      SELECT nom_film, id_film
      FROM film
      WHERE film.id_film NOT IN (
        SELECT film.id_film
        FROM film
        INNER JOIN gestion_genre g ON g.id_film = film.id_film
        INNER JOIN genre ON genre.id_genre = g.id_genre
        WHERE genre.id_genre = :id
      )
      ORDER BY nom_film
      ");
    $requeteOtherFilms->execute(["id" => $id]);

    require "view/filmsGenre.php";
  }
  

    // CREATION & SUPPRESSION //
  
}