<?php

namespace Controller;
use Model\Connect;

class CastingController {
  
  ////////////// SUPPRIMER CASTING //////////////


  // supprimer casting en fonction du film //

  public function supprimerCastingFilm($id) {
      $pdo = Connect::seconnecter();

      $role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_NUMBER_INT);

      // récupération de l'acteur et du film pour la notification
      $requeteCasting = $pdo->prepare("
      SELECT CONCAT(prenom, ' ', nom) AS fullName, nom_film
      FROM acteur a
      INNER JOIN personne p ON p.id_personne = a.id_personne
      INNER JOIN casting c ON c.id_acteur = a.id_acteur
      INNER JOIN role ON role.id_role = c.id_role
      INNER JOIN film ON film.id_film = c.id_film
      WHERE c.id_role = :idRole AND c.id_film = :idFilm
      ");
      $requeteCasting->execute([
        "idRole"=>$role,
        "idFilm"=>$id 
      ]);
      $casting = $requeteCasting->fetch();
      $nomFilm = $casting["nom_film"];
      $nomActeur = $casting["fullName"];

      // suppression du casting
      $requete = $pdo->prepare("
      DELETE FROM casting
      WHERE id_film = :id
      AND id_role = $role
      ");
      $requete->execute(["id"=>$id]);

      // + la notification
      $_SESSION["ValidatorMessages"][] = "
    <div class='notification remove'>
      <p>Le casting de <b>$nomActeur</b> dans <b>$nomFilm</b> est bien supprimé</p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

      header("Location:index.php?action=detailFilm&id=$id");
  }

  // supprimer casting en fonction de l'acteur //

  public function supprimerCastingActeur($id) {
      $pdo = Connect::seconnecter();

      $role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_NUMBER_INT);

      // récupération de l'acteur et du film pour la notif
      $requeteCasting = $pdo->prepare("
      SELECT CONCAT(prenom, ' ', nom) AS fullName, nom_film
      FROM acteur a
      INNER JOIN personne p ON p.id_personne = a.id_personne
      INNER JOIN casting c ON c.id_acteur = a.id_acteur
      INNER JOIN role ON role.id_role = c.id_role
      INNER JOIN film ON film.id_film = c.id_film
      WHERE c.id_role = :idRole AND c.id_acteur = :idActeur
      ");
      $requeteCasting->execute([
        "idRole"=>$role,
        "idActeur"=>$id 
      ]);
      $casting = $requeteCasting->fetch();
      $nomFilm = $casting["nom_film"];
      $nomActeur = $casting["fullName"];

        // suppression du casting
        $requete = $pdo->prepare("
        DELETE FROM casting
        WHERE id_acteur = :id
        AND id_role = $role
        ");
        $requete->execute(["id"=>$id]);

        // + la notif
        $_SESSION["ValidatorMessages"][] = "
        <div class='notification remove'>
          <p>Le casting de <b>$nomActeur</b> dans <b>$nomFilm</b> est bien supprimé</p>
          <i class='fa-solid fa-circle-xmark'></i>
        </div>";

        header("Location:index.php?action=detailActeur&id=$id");
  }


  //////////////// CREER CASTING ////////////////
  // en fonction de l'acteur 
  public function creerCastingActeur($idActeur) {
    $pdo = Connect::seconnecter();

    $role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $idFilm = filter_input(INPUT_POST, "film", FILTER_SANITIZE_NUMBER_INT);

    // on vérifie l'existence du role
    $findRole = $pdo->query("
    SELECT *
    FROM role
    WHERE nom_role = '$role'
    ");
    $roleResult = $findRole->fetch();

    // si le role n'existe pas, on le créait
    if(!$roleResult) {
      $createNewRole = $pdo->prepare("
      INSERT INTO role (nom_role)
      VALUES ('$role')
      ");
      $createNewRole->execute();
    
      $findRole = $pdo->query("
        SELECT *
        FROM role
        WHERE nom_role = '$role'
      ");
      $roleResult = $findRole->fetch();
    }
    // puis, on récupère l'idRole et on a les 3 id.
    $idRole = $roleResult["id_role"];
  
    $creationCasting = $pdo->prepare("
    INSERT INTO casting (id_film, id_acteur, id_role)
    VALUES ('$idFilm', '$idActeur', '$idRole')
    ");
    $creationCasting->execute();

    // On récupère le nom du film pour la notif
    $requeteFilm = $pdo->prepare('
    SELECT nom_film
    FROM film
    WHERE id_film = :id
    ');
    $requeteFilm->execute(["id"=>$idFilm]);
    $film = $requeteFilm->fetch();
    $nomFilm = $film["nom_film"];

    // + la notif
    $_SESSION["ValidatorMessages"][] = "
    <div class='notification add'>
      <p>Un nouveau casting dans <b>$nomFilm</b> a été créé</p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

    header("Location:index.php?action=detailActeur&id=$idActeur");
  }

  
  //////////////// CREER CASTING ////////////////
  ///////////// en fonction du film 
  
  public function creerCastingFilm($idFilm) {
    $pdo = Connect::seconnecter();

    $role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $idActeur = filter_input(INPUT_POST, "acteur", FILTER_SANITIZE_NUMBER_INT);

    // on vérifie l'existence du role
    $findRole = $pdo->query("
    SELECT *
    FROM role
    WHERE nom_role = '$role'
    ");
    $roleResult = $findRole->fetch();

    // si le role n'existe pas, on le créet
    if(!$roleResult) {
      $createNewRole = $pdo->prepare("
      INSERT INTO role (nom_role)
      VALUES ('$role')
      ");
      $createNewRole->execute();
      
      $findRole = $pdo->query("
        SELECT *
        FROM role
        WHERE nom_role = '$role'
      ");
      $roleResult = $findRole->fetch();
    }
    // puis, on récupère l'idRole et on a les 3 id-s.
    $idRole = $roleResult["id_role"];
    
    $creationCasting = $pdo->prepare("
    INSERT INTO casting (id_film, id_acteur, id_role)
    VALUES ('$idFilm', '$idActeur', '$idRole')
    ");
    $creationCasting->execute();

    // On récupère le nom de l'acteur pour la notification
    $requeteActeur = $pdo->prepare("
    SELECT CONCAT(prenom, ' ', nom) AS fullName
    FROM acteur
    INNER JOIN personne p ON p.id_personne = acteur.id_personne
    WHERE id_acteur = :id
    ");
    $requeteActeur->execute(["id"=>$idActeur]);
    $acteur = $requeteActeur->fetch();
    $nomActeur = $acteur["fullName"];

    // + la notif
    $_SESSION["ValidatorMessages"][] = "
    <div class='notification add'>
      <p>Un nouveau casting de <b>$nomActeur</b> a été créé</p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

    header("Location:index.php?action=detailFilm&id=$idFilm");
  }
}