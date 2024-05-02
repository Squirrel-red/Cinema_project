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
  // Ajouter un acteur (on l'ajoute comme un personne en précisant si cest un acteur ou réalisateur)


 // Supprimer un acteur
 public function supprimerActeur() {
  $pdo = Connect::seconnecter();

  $id_acteur = filter_input(INPUT_POST,'acteur', FILTER_SANITIZE_NUMBER_INT);

  // on récup le nom de l'acteur pour la notif
  $requeteActeur = $pdo->prepare("
  SELECT CONCAT(prenom, ' ', nom) as fullName
  FROM personne p
  INNER JOIN acteur a ON a.id_personne = p.id_personne
  WHERE id_acteur = :id
  ");
  $requeteActeur->execute(["id"=>$id_acteur]);
  $acteur = $requeteActeur->fetch();
  $nomActeur = $acteur["fullName"];

  // on supprime toute trace de l'acteur
  $requete = $pdo->prepare("
  DELETE FROM casting
  WHERE id_acteur = :id;

  DELETE FROM acteur
  WHERE id_acteur = :id;
  ");
  $requete->execute(["id"=>$id_acteur]);

  // + notif
  $_SESSION["ValidatorMessages"][] = "
  <div class='notification remove'>
    <p>Toute trace de l'acteur <b>".$nomActeur."</b> a été supprimée</p>
    <i class='fa-solid fa-circle-xmark'></i>
  </div>";

  header("Location:index.php?action=listActeurs");
}
}
