<?php

namespace Controller;
use Model\Connect;

class FilmController {

  // Affichage listFilms //
  public function listFilms() {
    $pdo = Connect::seConnecter();
    $requete = $pdo->query("
    SELECT *, date_sortie AS annee_sortie
    FROM film
    ORDER BY date_sortie DESC
    ");

    require "view/listFilms.php";
  }


  // Affichage detailFilm //
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
  
    // Formulaire pour créer un film //
    function creerFilmForm(){
      $pdo = Connect::seconnecter();
  
      // Récupération de tous les réalisateurs
      $requeteRealisateurs = $pdo->query("
        SELECT *, CONCAT(p.prenom, ' ', p.nom) AS fullName
        FROM realisateur r
        INNER JOIN personne p ON p.id_personne = r.id_personne
        ORDER BY nom");
  
      // Récupération de tous les genres
      $requeteGenres = $pdo->query("
        SELECT *
        FROM genre
        ORDER BY nom_genre");
  
      // On vérifie l'existance des attributs dans le GET
      // (il n'y en aura qu'un et $id prendra sa valeur)
  
      // Récupération du rea si dans url
      if (isset($_GET["rea"])) { 
        $id = $_GET["rea"];
  
        $requeteGetRea = $pdo->prepare("
          SELECT *, CONCAT(prenom, ' ', nom) AS fullName
          FROM realisateur r
          INNER JOIN personne p ON p.id_personne = r.id_personne
          WHERE id_realisateur = :id
          ");
        $requeteGetRea->execute(["id" => $id]);
      }
  
      // Récupération du genre si dans url
      if (isset($_GET["genre"])) { 
        $id = $_GET["genre"];
  
        $requeteGetGenre = $pdo->prepare("
          SELECT *
          FROM genre
          WHERE id_genre = :id
          ");
        $requeteGetGenre->execute(["id" => $id]);
      }
  
      // Récupération du acteur si dans url
      // if (isset($_GET["acteur"])) { 
      //   $id = $_GET["acteur"];
  
      //   $requeteGetActeur = $pdo->prepare("
      //     SELECT *, CONCAT(prenom, ' ', nom) AS fullName
      //     FROM acteur a
      //     INNER JOIN personne p ON p.id_personne = a.id_personne
      //     WHERE id_acteur = :id
      //     ");
      //   $requeteGetActeur->execute(["id" => $id]);
      // }
  
      require "view/form/formCreerFilm.php";
    }
  
    // Création du film ///
    function creationFilm(){
      $pdo = Connect::seconnecter();
  
      $nom = filter_input(INPUT_POST, "nom_film", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $duree = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_NUMBER_INT);
      $date = filter_input(INPUT_POST, "date_sortie");
      $synopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $affiche_film = filter_input(INPUT_POST, "affiche_film", FILTER_SANITIZE_URL);
      $note = filter_input(INPUT_POST, "note", FILTER_SANITIZE_NUMBER_FLOAT);
      $reaId = filter_input(INPUT_POST, "realisateur");
      
  
      $requeteCreation = $pdo->prepare("
      INSERT INTO film 
      (nom_film, duree, date_sortie, synopsis, affiche_film, note, id_realisateur)
      VALUES (:nom, :duree, :date, :synopsis, :affiche, :note, :reaId)
      ");
      $requeteCreation->execute([
        "nom" => $nom,
        "duree" => $duree,
        "date" => $date,
        "synopsis" => $synopsis,
        "affiche_film" => $affiche_film,
        "note" => $note,
        "reaId" => $reaId,
    ]);
  
      // + la notif de création
      $_SESSION["ValidatorMessages"][] = "
      <div class='notification add'>
        <p>La création du nouveau film <b>$nom</b> est bien effectuée</p>
        <i class='fa-solid fa-circle-xmark'></i>
      </div>";
  
    // On récupère l'id du film créé
    $id_film = $pdo->lastInsertId();
  
      // on veut un tableau de $genres 
      $genres = [];
  
      if (isset($_POST['genres'])) {
  
        foreach ($_POST["genres"] as $genre) {
          // on push chaque valeur filtrée dans le tableau $genres
          $genres[] = filter_var($genre, FILTER_SANITIZE_NUMBER_INT);
        }
      }
      // var_dump($genres);
  
      foreach($genres as $id_genre) {
        $requete = $pdo->prepare("
        INSERT INTO filmotheque
        (id_film, id_genre)
        VALUES (:film, :genre)
        ");
        $requete->execute([
          "film" => $id_film,
          "genre" => $id_genre
        ]);
  
        // On récupère le nom des genres pour la notif
        $requeteGenre = $pdo->prepare("
        SELECT *
        FROM genre
        WHERE id_genre = :id
        ");
        $requeteGenre->execute(["id" => $id_genre]);
        $genre = $requeteGenre->fetch();
        $nomGenre = $genre["nom_genre"];
  
        // + la notif d'ajout'
        $_SESSION["ValidatorMessages"][] = "
        <div class='notification add'>
          <p>Le film <b>$nom</b> s'est vu attribuer le genre <b>$nomGenre</b></p>
          <i class='fa-solid fa-circle-xmark'></i>
        </div>";
      }
      
      header("Location:index.php?action=listFilms");
    }
  
    // supprimer un film //
    function supprimerFilm() {
      $pdo = Connect::seconnecter();
  
      $id = filter_input(INPUT_POST, "film");
  
      // on récup le nom du film pour la notif
      $requeteNom = $pdo->prepare("
      SELECT nom_film
      FROM film
      WHERE id_film = :id
      ");
      $requeteNom->execute(["id"=>$id]);
      $film = $requeteNom->fetch();
      $nomFilm = $film["nom_film"];
  
      // requetes de suppression
      $requete = $pdo->prepare("
      DELETE FROM gestion_genre
      WHERE id_film = :id;
  
      DELETE FROM casting
      WHERE id_film = :id;
  
      DELETE FROM film
      WHERE id_film = :id;");
  
      $requete->execute(["id" => $id]);
  
      // + la notif
      $_SESSION["ValidatorMessages"][] = "
      <div class='notification remove'>
        <p>Le film <b>$nomFilm</b> a bien été supprimé</p>
        <i class='fa-solid fa-circle-xmark'></i>
      </div>";
      
      header("Location:index.php?action=listFilms");
    }


  // Modification du film //

  // Formulaire modification de film //
  public function modifFilmForm($id) {
    $pdo = Connect::seconnecter();

    // Récupération de tous les réalisateurs
    $requeteRealisateurs = $pdo->query("
      SELECT *, CONCAT(p.prenom, ' ', p.nom) AS fullName
      FROM realisateur r
      INNER JOIN personne p ON p.id_personne = r.id_personne
      ORDER BY nom");

    // Récupération de tous les genres
    $requeteGenres = $pdo->query("
      SELECT *
      FROM genre
      ORDER BY nom_genre");

    // récupération du film
    $requeteFilm = $pdo->prepare("
    SELECT *
    FROM film
    WHERE id_film = :id
    ");

    $requeteFilm->execute(["id" => $id]);

    $modif = true;

    require "view/form/formCreerFilm.php";    
  }

  // Mise a jour du film
  public function modifFilm($id) {
    $pdo = Connect::seconnecter();
    
    $nom = filter_input(INPUT_POST, "nom_film", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $duree = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_NUMBER_INT);
    $date = filter_input(INPUT_POST, "date_sortie");
    $synopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $affiche = filter_input(INPUT_POST, "affiche", FILTER_SANITIZE_URL);
    $note = filter_input(INPUT_POST, "note", FILTER_SANITIZE_NUMBER_FLOAT);
    $reaId = filter_input(INPUT_POST, "realisateur");
   
    $requete = $pdo->prepare("
    UPDATE film
    SET
        nom_film = :nom,
        duree = :duree,
        date_sortie = :date,
        synopsis = :synopsis,
        affiche = :affiche,
        note = :note,
        id_realisateur = :reaId
    WHERE id_film = :id
    ");
    $requete->execute([
      "nom" => $nom,
      "duree" => $duree,
      "date" => $date,
      "synopsis" => $synopsis,
      "affiche" => $affiche,
      "note" => $note,
      "reaId" => $reaId,
      "id" => $id,
  ]);

  $_SESSION["ValidatorMessages"][] = "
    <div class='notification add'>
      <p>Les informations sur le film <b>$nom</b> ont été mises à jour</p>
      <i class='fa-solid fa-circle-xmark'></i>
    </div>";

    header("Location:index.php?action=listFilms");
  }
  
}