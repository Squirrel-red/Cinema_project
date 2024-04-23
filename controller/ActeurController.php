<?php 

namespace Controller;
use Model\Connect;

class ActeurController {

  //////////// VIEW de la page detailActeur ////////////
  public function detailActeur($id) {
    $pdo = Connect::seConnecter();
    $requete = $pdo->prepare("
    SELECT *, CONCAT(p.prenom, ' ', p.nom) AS fullName, DATE_FORMAT(date_naissance, '%d/%m/%Y') AS date_naissance
    FROM acteur 
    INNER JOIN personne p ON p.id_personne = acteur.id_personne
    WHERE id_acteur = :id
    ");

    $requete->execute(["id" => $id]);

  // requete films de l'acteur
    $requeteFilms = $pdo->prepare('
    SELECT *, CONCAT(p.prenom, " ", p.nom) AS fullName
    FROM acteur a
    INNER JOIN personne p ON p.id_personne = a.id_personne
    INNER JOIN casting c ON c.id_acteur = a.id_acteur
    INNER JOIN role ON role.id_role = c.id_role
    INNER JOIN film ON film.id_film = c.id_film
    WHERE a.id_acteur = :id
    ORDER BY date_sortie DESC
    ');

    $requeteFilms->execute(["id" => $id]);

    $requeteAllFilms = $pdo->query("
    SELECT nom_film, id_film
    FROM film"
    );

    require "view/detailActeur.php";
  }

  // VIEW de la page listActeur //
  public function listActeurs() {
    $pdo = Connect::seConnecter();
    $requete = $pdo->query("
    SELECT *, CONCAT(nom, ' ', prenom) AS fullName
    FROM acteur
    INNER JOIN personne p ON p.id_personne = acteur.id_personne
    ORDER BY nom
    ");

    require "view/listActeurs.php";
  }
  // Ajouter un acteur
  // Supprimer un acteur

}