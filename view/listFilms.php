<?php ob_start(); 
$films = $requete->fetchAll();
?>

<section id="listFilms">

  <p class="nbInfo">Il y a <?= $requete->rowCount() ?> films dans la base de données.</p>

  <!--ici on code ajout/suppression du film ...-->

  <!-- ..                                       -->

  <!-- listing des films -->
  <p class="subtitle">Sélectionnez un film :</p>

  <table class="tableFilms">
    <thead>
      <tr>
        <th>AFFICHE</th>
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
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require "templates/template.php";