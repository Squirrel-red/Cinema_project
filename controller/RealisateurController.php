<?php

namespace Controller;
use Model\Connect;

class RealisateurController {
  
  // VIEW DE LA PAGE listRealisateurs //
  public function listRealisateurs() {
    $pdo = Connect::seConnecter();
    $requete = $pdo->query("
    SELECT *, CONCAT(nom, ' ', prenom) AS fullName
    FROM realisateur r
    INNER JOIN personne p ON p.id_personne = r.id_personne
    ORDER BY nom
    ");

    require "view/listRealisateurs.php";
  }

  // VIEW DE LA PAGE detailRealisateur //
  public function detailRealisateur($id) {
    $pdo = Connect::seConnecter();

// requete infos du realisateur
    $requeteRea = $pdo->prepare('
    SELECT id_realisateur, CONCAT(p.prenom, " ", p.nom) AS fullName, sexe, photo, DATE_FORMAT(date_naissance, "%d/%m/%Y") AS date_naissance
    FROM realisateur 
    INNER JOIN personne p ON p.id_personne = realisateur.id_personne
    WHERE id_realisateur = :id');
    
    $requeteRea->execute(["id" => $id]);

// requete films du realisateur
    $requeteFilms = $pdo->prepare('
    SELECT *, CONCAT(p.prenom, " ", p.nom) AS fullName
    FROM film
    INNER JOIN realisateur r ON film.id_realisateur = r.id_realisateur
    INNER JOIN personne p ON r.id_personne = p.id_personne 
    WHERE r.id_realisateur = :id
    ORDER BY date_sortie DESC');

    $requeteFilms->execute(["id" => $id]);

    // requete films sans realisateur
    $requeteOtherFilms = $pdo->query("
    SELECT id_film, nom_film
    FROM film
    WHERE id_realisateur IS NULL
    ");

    require "view/detailRealisateur.php";
  }


  //supprimer un réalisateur 
  public function supprimerRealisateur() {
    $pdo = Connect::seconnecter();

    $id_rea = filter_input(INPUT_POST,'rea', FILTER_SANITIZE_NUMBER_INT);

    // on récup le nom du réalisateur pour la notif
    $requeteRea = $pdo->prepare("
    SELECT CONCAT(prenom, ' ', nom) as fullName
    FROM personne p
    INNER JOIN realisateur r ON r.id_personne = p.id_personne
    WHERE id_realisateur = :id
    ");
    $requeteRea->execute(["id"=>$id_rea]);
    $rea = $requeteRea->fetch();
    $nomRea = $rea["fullName"];

    // on supprime toute trace du réalisateur
    $requete = $pdo->prepare("
    UPDATE film
    SET id_realisateur = NULL
    WHERE id_realisateur = :id;

    DELETE FROM realisateur
    WHERE id_realisateur = :id;
    ");
    $requete->execute(["id"=>$id_rea]);

    // + notif
    $_SESSION["ValidatorMessages"][] = "
    <div class='notification remove'>
      <p>Toute trace du réalisateur ".$nomRea." a été supprimée</p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

    header("Location:index.php?action=listRealisateurs");
  }

// supprimer le réalisateur d'un film 
  public function supprimerFilmRea($id) {
    $pdo = Connect::seConnecter();

    $film = filter_input(INPUT_POST,"film", FILTER_SANITIZE_NUMBER_INT);

    // on récupère le nom du film pour la notif
    $requeteFilm = $pdo->prepare("
    SELECT nom_film, CONCAT(prenom, ' ', nom) AS fullName
    FROM film
    INNER JOIN realisateur r ON r.id_realisateur = film.id_realisateur
    INNER JOIN personne p ON p.id_personne = r.id_personne
    WHERE film.id_realisateur = :idRea
    AND id_film = :idFilm
    ");
    $requeteFilm->execute([
      "idRea"=>$id,
      "idFilm"=> $film
    ]);
    $filmInfo = $requeteFilm->fetch();
    $nomFilm = $filmInfo["nom_film"];
    $nomRea = $filmInfo["fullName"];
    
    // on supprime le réalisateur DU FILM
    $requeteUpdate = $pdo->prepare("
    UPDATE film
    SET id_realisateur = NULL
    WHERE id_film = :id
    ");
    $requeteUpdate->execute(["id"=>$film]);

    // + notif
    $_SESSION["ValidatorMessages"][] = "
    <div class='notification remove'>
      <p>$nomRea a été supprimé du film $nomFilm</p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

    header("Location:index.php?action=detailRealisateur&id=$id");
  }

  public function ajouterFilmRea($id) {
    $pdo = Connect::seConnecter();

    $filmId = filter_input(INPUT_POST,"film", FILTER_SANITIZE_NUMBER_INT);

    // Update realisateur du film
    $requete = $pdo->prepare("
    UPDATE film
    SET id_realisateur = :idRea
    WHERE id_film = :idFilm
    ");
    $requete->execute([
      "idRea"=>$id,
      "idFilm"=> $filmId
    ]);

    // On récupère les noms pour la notif
    $requeteInfos = $pdo->prepare("
    SELECT nom_film, CONCAT(prenom, ' ', nom) AS fullName
    FROM film
    INNER JOIN realisateur r ON r.id_realisateur = film.id_realisateur
    INNER JOIN personne p ON p.id_personne = r.id_personne
    WHERE id_film = :id
    ");
    $requeteInfos->execute(["id" => $filmId]);
    $film = $requeteInfos->fetch();
    $nomFilm = $film["nom_film"];
    $nomRea = $film["fullName"];

    // + la notif
    $_SESSION["ValidatorMessages"][] = "
      <div class='notification add'>
        <p>Le film $nomFilm a été réalisé par $nomRea</p>
        <i class='fa-solid fa-circle-xmark'></i>
      </div>";

      header("Location:index.php?action=detailRealisateur&id=$id");
  }

}