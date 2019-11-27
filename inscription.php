<?php
    session_start();

    if (isset($_SESSION["user"])) {
        header("Refresh: 0; URL=/");
        die;
    }

    if (count($_POST) > 0) {
        extract($_POST);

        if ($password == $passwordConfirm) {
            $db = new mysqli("localhost", "root", "", "livreor");

            $request = "SELECT * FROM utilisateurs WHERE login = ?";
            $stmt = $db->prepare($request);
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            if (count($results) < 1) {
                $request = "INSERT INTO utilisateurs (login, password) VALUES (?, ?);";
                try {
                    $stmt = $db->prepare($request);
                    $stmt->bind_param("ss", $login, $password);
                    $success = $stmt->execute();
                } catch (Exception $e) {
                    echo "Exception reçue: {$e->getMessage()}";
                    die;
                }
            } else {
                $error = "Cet utilisateur existe déjà !";
            }
        } else {
            $error = "Le mot de passe que vous avez fourni ne correspond pas avec votre confirmation !";
        }
    }
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Inscription</title>
    </head>

    <body>
        <header>
            <h1>Livre d'or</h1>
            <a href="/">Retour</a>
        </header>
        <main id="inscription">
            <h2>Inscription</h2>
            <?php
            if (isset($error)) {
                echo "<h4 class='error'>$error</h4>";
            }
            if (isset($success) && $success) {
                echo "<h4 class='success'>Compte créé avec succès ! Vous pouvez dorénavant vous connecter...<br>Vous allez être redirigé dans 5 secondes...</h4>";
                header("Refresh: 5; URL=/connexion.php");
            } else { ?>
                <form method="post">
                    <div class="columns">
                        <div class="column">
                            <label for="login">Login</label>
                            <input type="text" name="login" required minlength="3" maxlength="255" value="<?= $login ?? '' ?>">
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" required minlength="3" maxlength="255">
                        </div>

                        <div class="column">
                            <label for="passwordConfirm">Mot de passe (confirmation)</label>
                            <input type="password" name="passwordConfirm" required minlength="3" maxlength="255">
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <input type="submit" value="S'inscrire">
                        </div>
                    </div>
                </form>
            <?php
            }
            ?>
        </main>
    </body>
</html>