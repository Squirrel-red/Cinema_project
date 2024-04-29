<?php ob_start(); 
$realisateurs = $requeteRealisateurs->fetchAll();
$genres = $requeteGenres->fetchAll();

// Sur ce formulaire on aura également récupéré $modif qui est utilisé si on veut modifier des données.
// On utilisera donc beaucoup la ternaire <?= isset($modif) ? "" : "" ? >

if (isset($modif)) {
  $filmModif = $requeteFilm->fetch();
}

// Récupération des données en fonction du type de GET (création seulement)
if(isset($_GET["genre"])) {
  $genreGet = $requeteGetGenre->fetch();
}
if(isset($_GET["rea"])) {
  $reaGet = $requeteGetRea->fetch();
}
if(isset($_GET["acteur"])) {
  $acteurGet = $requeteGetActeur->fetch();
} ?>

<form id="create"
  action="index.php?action=<?= isset($modif) ? "modifFilm&id=".$filmModif["id_film"] : "creationFilm" ?>" method="post">

  <fieldset id="globalFormInfo">
    <legend>Merci de renseigner tous les champs</legend>

    <div id="formNom">
      <label for="nom_film">Nom du film :</label>
      <input type="text" name="nom_film" id="nom_film"
        <?= isset($modif) ? "value='".$filmModif["nom_film"]."'" : null ?> required>
    </div>

    <div id="formDuree">
      <label for="duree">Durée en minutes :</label>
      <input type="number" name="duree" id="duree" <?= isset($modif) ? "value='".$filmModif["duree"]."'" : null ?>>
    </div>

    <div id="formDate">
      <label for="date_sortie">Date de sortie :</label>
      <input type="date" name="date_sortie" id="date_sortie"
        <?= isset($modif) ? "value='".$filmModif["date_sortie"]."'" : null ?>>
    </div>

    <div id="formSynopsis">
      <label for="synopsis">Synopsis :</label>
      <textarea name="synopsis" id="synopsis" rows="6"
        placeholder="Ecrivez une courte synopsis"><?= isset($modif) ? $filmModif["synopsis"] : null ?></textarea>
    </div>

    <div id="formImg">
      <label for="affiche">url de l'affiche :</label>
      <input type="text" name="affiche" id="affiche" <?= isset($modif) ? "value='".$filmModif["affiche"]."'" : null ?>>
    </div>

    <div id="formNote">
      <label for="note">Note :</label>
      <input type="number" min="0" max="5" step="0.1" name="note"
        <?= isset($modif) ? "value='".$filmModif["note"]."'" : null ?>>
    </div>

    <div id="formRea">

      <label for="realisateur">Réalisateur :</label>

      <!-- Si on créait un film à partir d'un réa -->
      <?php if(isset($_GET["rea"])) { ?>
      Vous avez sélectionné <?= $reaGet["fullName"] ?>.
      <input type="hidden" value="<?= $reaGet["id_realisateur"] ?>" name="realisateur">

      <!-- Si non on récupère tous les réa-->
      <?php } else { ?>
      <select name="realisateur">

        <!-- value="" permet de forcer un autre choix avec le required -->
        <option value="" disabled="disabled" <?= isset($filmModif["id_realisateur"]) ? null : 'selected="true"' ?>>
          Qui est le réalisateur ?
        </option>

        <?php foreach($realisateurs as $rea) { ?>

        <option value="<?= $rea["id_realisateur"] ?>"
          <?=
          // On va présélectionner le réalisateur s'il est déja choisi dans la base de donnée.
          (isset($filmModif["id_realisateur"]) && $filmModif["id_realisateur"] == $rea["id_realisateur"]) ? 'selected="true"' : null ?>>

          <?= $rea["fullName"] ?>
        </option>

        <?php } ?>

        <option value="">
          autre
        </option>
      </select>

      <?php } ?>
    </div>
  </fieldset>

  <?php if (!isset($modif)) { ?>

  <fieldset id="formGenres">

    <legend>Sélectionnez les genres</legend>

    <!-- Récupération des genres -->
    <?php foreach($genres as $genre) {?>
    <span class="checkboxContainer">
      <!-- Création de chaque box et vérification d'un possible id dans l'url -->
      <input type="checkbox" name="genres[]" id="<?= $genre["nom_genre"]?>" value="<?= $genre["id_genre"]?>"
        <?= (isset($genreGet) && $genre["id_genre"] == $genreGet["id_genre"] ) ? "checked" : "" ?> />

      <label for="<?= $genre["nom_genre"]?>"><?= $genre["nom_genre"]?></label>
    </span>
    <?php } ?>

  </fieldset>

  <fieldset id="castingsFormFilm">
    <legend>Listez les acteurs et rôles</legend>
  </fieldset>

  <?php } ?>

  <input type="submit" value="<?= isset($modif) ? "Mettre à jour" : "Créer nouveau" ?> film" class="submit-button">
</form>

<?php

$titre = (isset($modif) ? "Mise à jour" : "Création")." film";
$titre_secondaire = (isset($modif) ? "Mettre à jour" : "Créer")." un film";
$contenu = ob_get_clean();
require "templates/template.php";