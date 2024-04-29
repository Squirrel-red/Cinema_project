<?php

namespace Controller;
use Model\Connect;

class PersonneController {

// Formulaire de nouvelle personne
  public function creerFormPersonne($type) {
    $pdo = Connect::seconnecter();
    // $requete = $pdo->query('');
    require "view/form/formCreerPersonne.php";
  }

  //Création de la nouvelle personne
  public function creerPersonne() {
    $pdo = Connect::seconnecter();

    $nom = filter_input(INPUT_POST,'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $prenom = filter_input(INPUT_POST,'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sexe = filter_input(INPUT_POST,'sex');
    $date = filter_input(INPUT_POST,'date_naissance');
    $photo = filter_input(INPUT_POST,'photo', FILTER_SANITIZE_URL);

    $type =  filter_input(INPUT_POST,'type');
    $isReaActeur = isset($_POST["reaActeur"]) ? true : false;

    // On créait la personne
    $requetePersonne = $pdo->prepare("
    INSERT INTO personne 
    (nom, prenom, sexe, photo, date_naissance)
    VALUES (:nom, :prenom, :sexe, :photo, :date)
    ");
    $requetePersonne->execute([
      "nom" => $nom,
      "prenom" => $prenom,
      "sexe" => $sexe,
      "photo" => $photo,
      "date" => $date,
    ]);

    $_SESSION["ValidatorMessages"][] = "
      <div class='notification add'>
        <p>La personne <b>$prenom $nom</b> a été créée</p>
        <i class='fa-solid fa-circle-xmark'></i>
      </div>";

    // On récupère l'id directement!
    $id = $pdo->lastInsertId();

// On créait le nouveau acteur ou réa en fonction du type choisi
    $requeteType = $pdo->prepare("
      INSERT INTO $type (id_personne)
      VALUES ('$id')
      ");
    $requeteType->execute();

    // + la notif
    $_SESSION["ValidatorMessages"][] = "
    <div class='notification add'>
      <p>La création <b>".($type == "acteur" ? "de l'acteur" : "du réalisateur")."</b> est bien effectuée</p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

// Si c'est les 2 types, alors on le créait dans l'autre table.
    if($isReaActeur) {
      $otherType = (($type == 'acteur') ? "realisateur" : "acteur");

      $requeteOtherType = $pdo->prepare("
        INSERT INTO $otherType (id_personne)
        VALUES ('$id')
        ");
      $requeteOtherType->execute([]);

    // + notif
      $_SESSION["ValidatorMessages"][] = "
      <div class='notification add'>
        <p>La création <b>".($otherType == "acteur" ? "de l'acteur" : "du réalisateur")."</b> est bien effectuée</p>
        <i class='fa-solid fa-circle-xmark'></i>
      </div>";
    }

    // Retour a la page de liste du type sélectionné
    header("Location:index.php?action=list".ucwords($type)."s");
  }

  // Form de modification d'un personne
  public function modifPersonneForm($id, $type) {
    $pdo = Connect::seconnecter();

    $requete = $pdo->prepare("
    SELECT *
    FROM $type r
    INNER JOIN personne p ON p.id_personne = r.id_personne
    WHERE id_$type = :id
    ");

    $requete->execute(["id" => $id]);

    $modif = true;

    require "view/form/formCreerPersonne.php";    
  }

  // Mise a jour de la personne
  public function modifPersonne($id) {
    $pdo = Connect::seconnecter();
    
    $nom = filter_input(INPUT_POST,'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $prenom = filter_input(INPUT_POST,'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sexe = filter_input(INPUT_POST,'sex', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $date = filter_input(INPUT_POST,'date_naissance');
    $photo = filter_input(INPUT_POST,'photo', FILTER_SANITIZE_URL);

    $type =  filter_input(INPUT_POST,'type');

    $requetePersonne = $pdo->prepare("
    UPDATE personne
    SET
      nom = :nom,
      prenom = :prenom,
      sexe = :sexe,
      photo = :photo,
      date_naissance = :date
    WHERE id_personne = :id
    ");
    $requetePersonne->execute([
      "nom" => $nom,
      "prenom" => $prenom,
      "sexe" => $sexe,
      "photo" => $photo,
      "date" => $date,
      "id" => $id,
    ]);

    // + notif
    $_SESSION["ValidatorMessages"][] = "
      <div class='notification add'>
        <p>Les informations <b>".($type == "acteur" ? "de l'acteur" : "du réalisateur")."</b> ont bien été mises à jour</p>
        <i class='fa-solid fa-circle-xmark'></i>
      </div>";

    header("Location:index.php?action=list".ucwords($type)."s");
  }
}