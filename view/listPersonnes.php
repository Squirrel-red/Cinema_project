<?php ob_start(); ?>

<p class="uk-label uk-label-warning"> Il y a <?= $requete->rowCount() ?> personnes dans notre base de données :</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>N°</th>
            <th>PERSONNE</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $personne) { ?>
                <tr>
                    <td><?= $personne["id"] ?></td>
                    <td><?= $personne["personne"] ?></td>

                </tr>
            <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des personnes";
$titre_secondaire = "Liste des personnes";
$contenu = ob_get_clean();
require_once "view/template.php";