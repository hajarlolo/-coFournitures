<?php
session_start();
include('connexion.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Vérifier que l'ID du produit est présent dans l'URL
if (!isset($_GET['id_produit'])) {
    echo "Produit introuvable.";
    exit;
}
$id_produit = intval($_GET['id_produit']);

$id_utilisateur = $_SESSION['id'];

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['commentaire'])) {
    $commentaire = htmlspecialchars($_POST['commentaire']);

    $sql = "INSERT INTO commentaires (id_produit, id_utilisateur, commentaire) VALUES (?, ?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id_produit, $id_utilisateur, $commentaire]);

    header("Location: produit.php?id=" . $id_produit);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un commentaire</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: rgb(255, 245, 207);
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: rgb(90, 68, 58);
            margin-bottom: 20px;
        }

        form {
            background-color: rgba(255, 255, 255, 0.71);
            padding: 20px;
            border-radius: 10px;
        }

        textarea {
            width: 95%;
            height: 120px;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid rgb(90, 68, 58);
            font-size: 1em;
            resize: vertical;
            background-color: #fff;
            color: rgb(90, 68, 58);
            margin-bottom: 10px;
        }

        button {
            background-color: rgb(90, 68, 58);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }

        button:hover {
            background-color: #6d4c41;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: rgb(90, 68, 58);
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Laisse ton commentaire</h2>

        <form method="post">
            <label for="commentaire">Ton message :</label><br>
            <textarea name="commentaire" id="commentaire" required></textarea><br>
            <button type="submit">Envoyer</button>
        </form>

        <a href="produit.php?id=<?php echo $id_produit; ?>">⬅ Retour au produit</a>
    </div>

</body>

</html>