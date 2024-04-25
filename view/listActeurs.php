<?php ob_start();
$acteurs = $requete->fetchAll();
?>
<section id="listActeurs">


  <div class='buttons'>

    <!-- ajouter acteur -->
    <a href="index.php?action=creerFormActeur">
      <button class="addButton">créer un acteur</button>
    </a>

    <!-- supprimer acteur -->

    <div class="removeContainer">
      <button class="removeButton">retirer un acteur</button>

      <form id="removeActeur" class="divWarning" action="index.php?action=supprimerActeur" method="post">
        <select name="acteur" class="warner" required>
          <option selected="true" value="" disabled="disabled">
            Choisissez un acteur
          </option>
          <?php foreach($acteurs as $acteur) { ?>

          <option value="<?= $acteur["id_acteur"] ?>">
            <?= $acteur["fullName"] ?>
          </option>

          <?php } ?>
        </select>

        <span class="warningMessage warningCache">Attention, supprimer un acteur le supprimera de tous les films</span>

        <input type="submit" value="valider">
      </form>
    </div>
  </div>


  <!-- lister acteurs  -->
  <div class="cards-container">

    <?php foreach($acteurs as $person){
      $type = "acteur";

    require "templates/personCard.php";
    } ?>
  </div>
</section>

<?php
$titre = "Liste des acteurs";
$titre_secondaire = "Liste des acteurs";
$contenu = ob_get_clean();
require "templates/template.php";