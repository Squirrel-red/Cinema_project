<?php ob_start();
$realisateurs = $requete->fetchAll() ?>

<section id="listRealisateurs">

  <!--créer rea -->
  <div class='buttons'>
    <a href="index.php?action=creerFormRealisateur">
      <button class="addButton">créer un réalisateur</button>
    </a>

    <!-- supprimer rea -->

    <div class="removeContainer">
      <button class="removeButton">retirer un réalisateur</button>

      <form id="removeRea" action="index.php?action=supprimerRealisateur" method="post">
        <select name="rea" required>
          <option selected="true" value="" disabled="disabled">
            Choisissez un réalisateur
          </option>
          <?php foreach($realisateurs as $rea) { ?>

          <option value="<?= $rea["id_realisateur"] ?>">
            <?= $rea["fullName"] ?>
          </option>

          <?php } ?>
        </select>
        <input type="submit" value="valider">
      </form>
    </div>
  </div>

    <!--lister rea --> 
  <div class="cards-container">

    <?php foreach($realisateurs as $person){
      $type = "realisateur";
      require "templates/personCard.php";
    } ?>

  </div>
</section>
<?php
$titre = "Liste des realisateurs";
$titre_secondaire = "LISTE DES REALISATEURS";
$contenu = ob_get_clean();
require "templates/template.php";