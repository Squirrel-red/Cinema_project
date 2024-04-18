<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- REMIXICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" integrity="sha512-OQDNdI5rpnZ0BRhhJc+btbbtnxaj+LdQFeh0V9/igiEPDiWE2fG+ZsXl0JEH+bjXKPJ3zcXqNyP4/F/NegVdZg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS -->
    <link rel="stylesheet" href="public/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    
    <title><?= $titre ?></title>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <nav class="nav_container">
            <div class="nav_home">
                <a href="index.php?action=home_view">HOME</a>
            </div>
            <div class="nav_menu">
                <ul class="nav_menu_list">
                    <li class="nav_item">
                        <a href="index.php?action=film_view&genre=Action">FILM</a>
                    </li>
                    <li class="nav_item">
                        <a href="index.php?action=realisateur_view">REALISATEUR</a>
                    </li>
                    <li class="nav_item">
                        <a href="index.php?action=acteur_view">ACTEUR</a>
                    </li>
                </ul>
            </div>
            <div class="nav_add">
                <a href="index.php?action=add_view">
                    <i class="ri-user-settings-fill"></i>
                </a>
            </div>
        </nav>

    </header>
    <!-- MAIN -->
    <main>
        <h1><?= $titre ?></h1>
        <?= $contenu ?>
    </main>
    
</body>
    <script src="public/js/swiper-bundle.min.js"></script>
    <script src="public/js/main.js"></script>
</html>