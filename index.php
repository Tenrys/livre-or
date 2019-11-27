<?php
    session_start();

    if (isset($_SESSION["user"])) {
        extract($_SESSION["user"]);
    }
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>
<body>
    <header>
        <h1>Livre d'or</h1>
    </header>
    <main id="index">
        <h2>Bienvenue <?= isset($login) ? ($login . ' ') : ' ' ?>!</h2>
        <p>Que souhaitez-vous faire ?</p>
        <div class="buttons">
            <?php
                if (!isset($_SESSION["user"])) {
                    echo '<a href="inscription.php">Inscription</a>';
                    echo '<a href="connexion.php">Connexion</a>';
                } else {
                    echo '<a href="livre-or.php">Livre d\'or</a>';
                    echo '<a href="profil.php">Profil</a>';
                    echo '<a href="deconnexion.php">Déconnexion</a>';
                }
            ?>
        </div>
    </main>
</body>
</html>