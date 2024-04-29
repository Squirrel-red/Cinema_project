<?php ob_start(); 
$films = $requete->fetchAll();
?>

<section id="listFilms">

  <p class="nbInfo">Il y a <?= $requete->rowCount() ?> films dans la base de données.</p>

  <!--ajout/suppression du film -->

  <div class='buttons'>
    <a href="index.php?action=creerFilm">
      <button class="createButton">créer un film</button>
    </a>

    <div class="removeContainer">
      <button class="removeButton">supprimer un film</button>

      <!-- insertion des films existants dans la liste -->
      <form id="removeFilm" action="index.php?action=supprimerFilm" method="post">
        <select name="film" required>
          <option selected="true" value="" disabled="disabled">
            Choisissez un film
          </option>
          <?php foreach($films as $film) { ?>

          <option value="<?= $film["id_film"] ?>">
            <?= $film["nom_film"] ?>
          </option>

          <?php } ?>
        </select>
        <input type="submit" value="valider">
      </form>
    </div>
  </div>

  <!-- listing des films -->
  <p class="subtitle">Sélectionnez un film :</p>

  <table class="tableFilms">
    <thead>
      <tr>
        <!--<th>AFFICHE</th>-->
        <th colspan="2">TITRE</th>
        <th>DATE SORTIE</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($films as $film) { 
        $href = "index.php?action=detailFilm&id=".$film["id_film"];
        ?>

      <tr>
        <td class="afficheTableFilm">
          <div class="link">
            <a class href="<?= $href ?>">
              <img src="<?= $film["affiche_film"] ?>" alt="affiche du film <?= $film["nom_film"] ?>">
            </a>
          </div>
        </td>

        <td class="filmTableNom">
          <div class="link subtitle">
            <a href="<?= $href ?>">
              <?= $film["nom_film"] ?>
            </a>
          </div>
        </td>

        <td class="filmTableDate">
          <?= $film["annee_sortie"] ?>
        </td>
      </tr>

      <?php  } ?>
    </tbody>
  </table>
</section>

<?php
$titre = "Liste des films";
$titre_secondaire = "LISTE DES FILMS";
$contenu = ob_get_clean();
require "templates/template.php";