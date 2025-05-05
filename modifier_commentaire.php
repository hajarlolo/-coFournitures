<?php
session_start();
include('connexion.php');

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: signin.php");
    exit;
}

// Récupère l'ID du commentaire et du produit (retour après modif)
if (!isset($_GET['id']) || !isset($_GET['produit'])) {
    header("Location: acceuil.php");
    exit;
}

$id_commentaire = $_GET['id'];
$id_produit = $_GET['produit'];

// Vérifie que le commentaire appartient bien à l'utilisateur
$sql = "SELECT * FROM commentaires WHERE id = ?";
$stmt = $connexion->prepare($sql);
$stmt->execute([$id_commentaire]);
$commentaire = $stmt->fetch();

if (!$commentaire || $commentaire['id_utilisateur'] != $_SESSION['id']) {
    echo "Accès non autorisé.";
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouveau_commentaire = htmlspecialchars(trim($_POST['commentaire']));

    if (!empty($nouveau_commentaire)) {
        $update = "UPDATE commentaires SET commentaire = ? WHERE id = ?";
        $stmt = $connexion->prepare($update);
        $stmt->execute([$nouveau_commentaire, $id_commentaire]);

        header("Location: produit.php?id=$id_produit");
        exit;
    } else {
        $erreur = "Le commentaire ne peut pas être vide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon commentaire</title>
    <style>
        :root {
            --brun: rgb(90, 68, 58);
            --beige: rgb(255, 245, 207);
        }

        body {
            background-color: var(--beige);
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        .form-container {
            max-width: 500px;
            margin: auto;
            background-color: white;
            border: 2px solid var(--brun);
            padding: 30px;
            border-radius: 15px;
        }

        h2 {
            color: var(--brun);
            text-align: center;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        button, .btn-cancel {
            background-color: var(--brun);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        button:hover, .btn-cancel:hover {
            background-color: #4b362c;
        }

        .erreur {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Modifier votre commentaire</h2>
        <?php if (isset($erreur)): ?>
            <p class="erreur"><?php echo $erreur; ?></p>
        <?php endif; ?>
        <form method="POST">
            <textarea name="commentaire"><?php echo html_entity_decode(htmlspecialchars($commentaire['commentaire']));
 ?></textarea>
            <div class="btn-group">
                <button type="submit">Enregistrer</button>
                <a href="produit.php?id=<?php echo $id_produit; ?>" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>
