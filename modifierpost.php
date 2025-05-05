<?php
session_start();
include('connexion.php');

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$id_utilisateur = $_SESSION['id'];

if (!isset($_GET['id'])) {
    header('Location: compte.php');
    exit;
}

$id_post = $_GET['id'];

// Récupérer le post
$stmt = $connexion->prepare("SELECT * FROM produits WHERE id = ? AND id_utilisateur = ?");
$stmt->execute([$id_post, $id_utilisateur]);
$post = $stmt->fetch();

if (!$post) {
    echo "Post introuvable ou accès refusé.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $categorie = $_POST['categorie'];
    $description = $_POST['description'];
    $statut = $_POST['statut'];
    $ville = $_POST['ville'];
    $quartier = $_POST['quartier'];

    // Gérer la photo
    $photo = $post['photo']; // valeur par défaut
    if (!empty($_FILES['photo']['name'])) {
        $fichier = $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];
        $destination = 'images/' . $fichier;

        if (move_uploaded_file($tmp, $destination)) {
            if (!empty($photo) && file_exists('images/' . $photo)) {
                unlink('images/' . $photo); // supprimer l'ancienne photo
            }
            $photo = $fichier;
        }
    }

    // Mettre à jour la base de données
    $stmt = $connexion->prepare("UPDATE produits SET titre = ?, categorie = ?, description = ?, statut = ?, ville = ?, quartier = ?, photo = ? WHERE id = ? AND id_utilisateur = ?");
    $stmt->execute([$titre, $categorie, $description, $statut, $ville, $quartier, $photo, $id_post, $id_utilisateur]);

    header('Location:moncompte.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(255, 245, 207);
            padding: 40px;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, textarea, select {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        img {
            max-width: 100%;
            margin-top: 10px;
            border-radius: 5px;
        }
        button {
            background-color: rgb(90, 68, 58);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: rgb(125, 100, 87);
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <h2>Modifier un Post</h2>
        <label>Titre :</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($post['titre']) ?>" required>

        <label>Catégorie :</label>
        <input type="text" name="categorie" value="<?= htmlspecialchars($post['categorie']) ?>" required>

        <label>Description :</label>
        <textarea name="description" required><?= htmlspecialchars($post['description']) ?></textarea>

        <label>Statut :</label>
        <select name="statut" required>
            <option value="Disponible" <?= $post['statut'] === 'Disponible' ? 'selected' : '' ?>>Disponible</option>
            <option value="Épuisé" <?= $post['statut'] === 'Épuisé' ? 'selected' : '' ?>>Épuisé</option>
        </select>

        <label>Ville :</label>
        <input type="text" name="ville" value="<?= htmlspecialchars($post['ville']) ?>" required>

        <label>Quartier :</label>
        <input type="text" name="quartier" value="<?= htmlspecialchars($post['quartier']) ?>" required>

        <label>Changer la photo :</label>
        <input type="file" name="photo">
        <?php if ($post['photo']): ?>
            <img src="images/<?= htmlspecialchars($post['photo']) ?>" alt="Ancienne image">
        <?php endif; ?>

        <button type="submit">Enregistrer les modifications</button>
    </form>
</body>
</html>
