<?php ob_start(); 
$detailRealisateur = $requeteRea->fetch();
$reaFilms = $requeteFilms->fetchAll();
$otherFilms = $requeteOtherFilms->fetchAll();
?>

<h3><?= $detailRealisateur["fullName"] ?></h3>

<!-- infos du realisateur -->
<section id="personInfos">
  <figure>
    <img src="<?= $detailRealisateur["photo"] ?>" alt="photo de <?= $detailRealisateur["fullName"] ?>">
    <figcaption>
      <p>
        <?= $detailRealisateur["fullName"] ?> est
        <!-- vérification du sexe -->
        <?php switch ( $detailRealisateur["sexe"] ) {
          case "Homme": 
            echo "un homme, né";
            break;
          case "Femme": 
            echo "une femme, née";
            break;
          default:
            echo "quelqu'un né";
            break;
        } ?>

        le <?= $detailRealisateur["date_naissance"] ?>.
      </p>
    </figcaption>
  </figure>
</section>

<div class="buttons">
  <a href="index.php?action=modifRealisateurForm&id=<?= $detailRealisateur["id_realisateur"] ?>">
    <button><i class="fa-solid fa-pen editButton"></i>
      modifier les infos
    </button>
  </a>
</div>

<hr>
<!-- Films du realisateur -->
<section id="realisations">
  <h4>Ses réalisations :</h4>

  <p class="subtitle">
    <?php switch($detailRealisateur["sexe"]) {
      case "Homme" : echo "Il a"; break;
      case "Femme" : echo "Elle a"; break;
      default : echo "A"; break;
    }
    ?>
    réalisé <?= $requeteFilms->rowCount() ?> films :
  </p>

    <!-- créer un nouveau film -->


    <!-- ajouter un film (sans rea) -->


    <!-- supprimer le réa d'un film -->


  <table class="tableFilms">
    <thead>
      <tr>
        <th colspan="2">TITRE</th>
        <th>DATE SORTIE</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($reaFilms as $film) { 
        $href = "index.php?action=detailFilm&id=".$film["id_film"];
        ?>

      <tr>
        <td class="afficheTableFilm">
          <div class="link">
            <a class href="<?= $href ?>">
              <img src="<?= $film["affiche"] ?>" alt="affiche du film <?= $film["nom_film"] ?>">
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
          <?= $film["date_sortie"] ?>
        </td>
      </tr>

      <?php  } ?>
    </tbody>
  </table>
</section>
<?php
$titre = "détail Realisateur";
$titre_secondaire = $detailRealisateur["fullName"];
$contenu = ob_get_clean();
require "templates/template.php";