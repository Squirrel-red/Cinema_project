<?php ob_start(); ?>

<p class="uk-label uk-label-warning"> Il y a <?= $requete->rowCount() ?> acteurs dans notre base de données :</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>N°</th>
            <th>ACTEUR</th>
            <th>PROFIL</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $acteur) { ?>
                <tr>
                    <td><?= $acteur["id"] ?></td>
                    <td><?= $acteur["personne"] ?></td>
                    <td><?= $acteur["profil"] ?></td>

                </tr>
            <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des acteurs/actrices";
$titre_secondaire = "Liste des acteurs/actrices";
$contenu = ob_get_clean();
require_once "templates/template.php";