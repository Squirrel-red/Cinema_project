<?php ob_start(); 

// Sur ce formulaire on aura également récupéré $modif qui est utilisé si on veut modifier des données.
// On utilisera donc beaucoup la ternaire <?= isset($modif) ? "" : "" ? >
if (isset($modif)) {
  $personne = $requete->fetch();
}
?>

<form id="create"
  action="index.php?action=<?= isset($modif) ? "modifPersonne&id=".$personne["id_personne"] : "creerPersonne"?>"
  method="post">

  <fieldset id="globalFormInfo">
    <legend>Merci de renseigner tous les champs</legend>

    <div id="formNom">
      <label for="nom">Nom :</label>
      <input type="text" name="nom" id="nom" <?= isset($modif) ? "value='".$personne["nom"]."'" : null ?> required>
    </div>

    <div id="formPrenom">
      <label for="prenom">Prénom :</label>
      <input type="text" name="prenom" id="prenom" <?= isset($modif) ? "value='".$personne["prenom"]."'" : null ?>
        required>
    </div>

    <div id="formSex">
      <label for="sex">Sexe :</label>

      <select name="sex" id="sex" required>

        <!-- value="" permet de forcer un autre choix avec le required -->
        <option <?= isset($personne["sexe"]) ? null : 'selected="true"' ?> value="" disabled="disabled">
          Quel sexe ?
        </option>
        <option value="Homme"
          <?= (isset($personne["sexe"]) && $personne["sexe"] == "Homme") ? 'selected="true"' : null ?>>
          Homme
        </option>
        <option value="Femme"
          <?= (isset($personne["sexe"]) && $personne["sexe"] == "Femme") ? 'selected="true"' : null ?>>
          Femme
        </option>
        <option value="autre"
          <?= (isset($personne["sexe"]) && $personne["sexe"] == "autre") ? 'selected="true"' : null ?>>
          Autre
        </option>
      </select>
    </div>

    <div id="formDate">
      <label for="date_naissance">Date de naissance :</label>
      <input type="date" name="date_naissance" id="date_naissance"
        <?= isset($modif) ? "value='".$personne["date_naissance"]."'" : null ?> required>
    </div>

    <div id="formImg">
      <label for="photo">url d'une photo :</label>
      <input type="text" name="photo" id="photo" <?= isset($modif) ? "value='".$personne["photo"]."'" : null ?>
        required>
    </div>

    <!-- On ne demande si c'est un acteur & réalisateur qu'à la création d'une nouvelle personne -->

    <?php if(!isset($modif)) { ?>
    <div id="isReaActeur">
      <span class="checkboxContainer">
        <input type="checkbox" name="reaActeur" id="reaActeur">

        <!-- Vérification si acteur & réalisateur -->
        <label for="reaActeur">
          Cochez la case si c'est également un
          <?php
          echo ($type == "acteur" ? "réalisateur": "acteur")
          ?>
        </label>

      </span>
    </div>

    <?php } ?>

  </fieldset>
  <!-- envoi caché du type (acteur ou rea) -->
  <input type="hidden" name="type" value="<?= $type ?>">

  <input type="submit" value="<?= isset($modif) ? "Modifier" : "Créer nouveau" ?> <?= $type ?>" class="submit-button">
</form>

<?php
$titre = (isset($modif) ? "Modification " : "Création ").$type;
$titre_secondaire = (isset($modif) ? "Modifier" : "Créer")." un ".$type;
$contenu = ob_get_clean();
require "templates/template.php";