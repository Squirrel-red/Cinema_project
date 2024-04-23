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
    SELECT id_realisateur, CONCAT(p.prenom, " ", p.nom) AS fullName, sexe, date_naissance, photo, DATE_FORMAT(date_naissance, "%d/%m/%Y") AS date_naissance
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

  //supprimer un réalisateur //
 
  //update realisateur du film //

  // On récupère les noms pour la notif
  // la notification avec le nom

}