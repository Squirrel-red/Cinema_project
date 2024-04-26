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
  
   //////////// Formulaire ajout genre ////////////
   public function ajouterGenre() {
    $pdo = Connect::seConnecter();

    // récupération du genre
    $nom_genre = filter_input(INPUT_POST,'nom_genre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $requete = $pdo->prepare("
      INSERT INTO genre (nom_genre)
      VALUES ('$nom_genre')
      ");
    $requete->execute();

    $_SESSION["ValidatorMessages"][] = "
    <div class='notification add'>
      <p>Le genre <b>$nom_genre</b> a bien été créé</p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

    header('Location:index.php?action=listGenres');
  }

  ////////// Formulaire suppression genre //////////
  public function supprimerGenre() {
    $pdo = Connect::seConnecter();

    $id_genre = filter_input(INPUT_POST,'genre', FILTER_SANITIZE_NUMBER_INT);

    // on récupère le genre pour la notif
    $requeteGenre = $pdo->prepare('
    SELECT *
    FROM genre
    WHERE id_genre = :id');
    $requeteGenre->execute(['id' => $id_genre]);
    $genre = $requeteGenre->fetch();
    $nom_genre = $genre['nom_genre'];

    // Suppression des films associés avant de supprimer le genre
    $requeteDel = $pdo->prepare("
      DELETE FROM gestion_genre
      WHERE id_genre = :id;

      DELETE FROM genre
      WHERE id_genre = :id;
    ");
    $requeteDel->execute(['id' => $id_genre]);

    // + notif
    $_SESSION["ValidatorMessages"][] = "
    <div class='notification add'>
      <p>Le genre <b>$nom_genre</b> a bien été créé</p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

    header('Location:index.php?action=listGenres');
  }

    ////////////// GENRES D'UN FILM //////////////

  ///////////// Ajouter le genre d'un film /////////////
  public function ajouterGenreFilm($id) {
    $pdo = Connect::seconnecter();

    $film = filter_input(INPUT_POST,'film', FILTER_VALIDATE_INT);

    $requete = $pdo->prepare("
      INSERT INTO gestion_genre (id_film, id_genre)
      VALUES (:idFilm, :idGenre) 
      ");
    $requete->execute([
      "idGenre" => $id,
      "idFilm" => $film
    ]);

    // on récupère le nom du genre et du film pour la notif
    $requeteInfos = $pdo->prepare("
    SELECT nom_genre, nom_film
    FROM gestion_genre g
    INNER JOIN film ON film.id_film = g.id_film
    INNER JOIN genre ON genre.id_genre = g.id_genre
    WHERE g.id_film = :idFilm AND g.id_genre = :idGenre
    ");
    $requeteInfos->execute([
      "idGenre"=> $id,
      "idFilm"=> $film
    ]);
    $filmo = $requeteInfos->fetch();
    $nom_genre = $filmo["nom_genre"];
    $nom_film = $filmo["nom_film"];

    // + notif
    $_SESSION["ValidatorMessages"][] = "
    <div class='notification add'>
      <p>Le genre <b>$nom_genre</b> a été attibué au film <b>$nom_film</b></p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

    header('Location:index.php?action=filmsGenre&id='.$id);
  }

  //////////// Supprimer le genre d'un film ////////////
  public function supprimerGenreFilm($id) {
    $pdo = Connect::seconnecter();

    $film = filter_input(INPUT_POST,'film', FILTER_VALIDATE_INT);

    // on récupère les noms du genre et du film pour la notif
    $requeteInfos = $pdo->prepare('
    SELECT nom_genre, nom_film
    FROM gestion_genre g
    INNER JOIN film ON film.id_film = g.id_film
    INNER JOIN genre ON genre.id_genre = g.id_genre
    WHERE g.id_film = :idFilm AND g.id_genre = :idGenre
    ');
    $requeteInfos->execute([
      "idGenre" => $id,
      "idFilm" => $film,
    ]);
    $filmo = $requeteInfos->fetch();
    $nomGenre = $filmo["nom_genre"];
    $nomFilm = $filmo["nom_film"];

    // suppression du genre
    $requete = $pdo->prepare("
      DELETE FROM gestion_genre
      WHERE id_genre = :idGenre
      AND id_film = :idFilm
      ");
    $requete->execute([
      "idGenre" => $id,
      "idFilm" => $film
    ]);

    // + la notif
    $_SESSION["ValidatorMessages"][] = "
    <div class='notification remove'>
      <p><b>$nomFilm</b> est supprimé du genre <b>$nomGenre</b></p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

    header('Location:index.php?action=filmsGenre&id='.$id);
  }
}