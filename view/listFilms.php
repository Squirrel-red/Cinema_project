<?php ob_start(); ?>

<p class="uk-label uk-label-warning"> Il y a <?= $requete->rowCount() ?> films dans notre base de données :</p>
 
<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>N°</th>
            <th>TITRE</th>
            <th>ANNEE SORTIE</th>
            <th>AFFICHE</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $film) { ?>
                <tr>
                    <td><?= $film["id"] ?></td>
                    <td><?= $film["titre"] ?></td>
                    <td><?= $film["date_sortie"] ?></td>
                    <td><?= $film["affiche_film"] ?></td>

                </tr>
            <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require_once "view/template.php";