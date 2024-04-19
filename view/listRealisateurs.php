<?php ob_start(); ?>

<p class="uk-label uk-label-warning"> Il y a <?= $requete->rowCount() ?> réalisateurs dans notre base de données :</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>N°</th>
            <th>REALISATEUR</th>
            <th>INFORMATION</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $realisateur) { ?>
                <tr>
                    <td><?= $realisateur["id"] ?></td>
                    <td><?= $realisateur["personne"] ?></td>
                    <td><?= $realisateur["profil"] ?></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des réalisateurs";
$titre_secondaire = "Liste des réalisateurs";
$contenu = ob_get_clean();
require_once "view/template.php";