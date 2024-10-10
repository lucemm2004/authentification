<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css">
        <title>Accueil</title>
    </head>
    <body>
        <div class="accueil-container">
            <!-- <p class="<?= $class ?>"><?= $msg ?></p> -->
            <h1>Bienvenue <span><?= $_SESSION['username']?></span></h1>
            <a href="logout.php">Déconnexion (logout)</a>
        </div>
    </body>
</html>
