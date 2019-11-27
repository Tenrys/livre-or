<?php
    session_start();

    if (!isset($_SESSION["user"])) {
        header("Refresh: 0; URL=/connexion.php");
        die;
    }

    extract($_SESSION["user"]);
    extract($_POST);

    $db = new mysqli("localhost", "root", "", "livreor");

    if (isset($commentaire)) {
        $request = "INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (?, ?, NOW())";
        $stmt = $db->prepare($request);
        $stmt->bind_param("ss", $commentaire, $id);
        $stmt->execute();

        header("Refresh: 0; URL=/livre-or.php");
        die;
    }
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Livre d'or</title>
</head>
<body>
    <header>
        <h1>Livre d'or</h1>
        <a href="/livre-or.php">Retour</a>
    </header>
    <main id="commentaire">
        <form method="post">
            <label>Poster un commentaire en tant que "<i><?= $_SESSION["user"]["login"] ?></i>":</label>
            <br/>
            <textarea name="commentaire" style="width: 100%; min-height: 64px;"></textarea>
            <input type="submit" value="Envoyer">
        </form>
    </main>
</body>
</html>