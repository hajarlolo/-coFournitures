<?php
session_start();
include('connexion.php');

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer un Post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --fonce: rgb(90, 68, 58);
            --clair: rgb(255, 245, 207);
            --hover: rgb(125, 100, 87);
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: var(--clair);
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
            margin-top: 0;

        }

/*         .sidebar {
            margin: 1;
            width: 250px;
            background-color: var(--fonce);
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            margin-top: 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
        } */

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: var(--clair);
        }

        .create-post-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            max-width: 700px;
            margin: auto;
        }

        .create-post-form h2 {
            text-align: center;
            color: var(--fonce);
            margin-bottom: 5px;
            margin-top: 0px;
        }

        .create-post-form label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
            color: var(--fonce);
        }

        .create-post-form input[type="text"],
        .create-post-form input[type="file"],
        .create-post-form textarea,
        .create-post-form select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            color: var(--fonce);
        }

        .create-post-form textarea {
            resize: none;
            height: 40px;
        }


        .create-post-form button {
            margin-top: 10px;
            margin-bottom: 0;
            width: 100%;
            padding: 12px;
            background-color: var(--fonce);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .create-post-form button:hover {
            background-color: var(--hover);
        }

        .des {
            height: 20px;
        }
    </style>

</head>

<body>
    <div class="dashboard">
        <div class="main-content">
            <div class="create-post-form">
                <h2>Créer un nouveau Post</h2>
                <form action="traitement.php" method="POST" enctype="multipart/form-data">
                    <label for="titre">Titre du produit</label>
                    <input type="text" name="titre" required>

                    <label for="description">Description</label>
                    <textarea class="des" name="description" required></textarea>

                    <label for="categorie">Catégorie</label>
                    <input type="text" name="categorie" required>

                    <label for="ville">Ville</label>
                    <input type="text" name="ville" required>

                    <label for="quartier">Quartier</label>
                    <input type="text" name="quartier" required>

                    <label for="photo">Photo (à venir)</label>
                    <input type="file" name="photo" accept="image/*">

                    <label for="statut">Statut</label>
                    <select name="statut" required>
                        <option value="disponible">Disponible</option>
                        <option value="non_disponible">Non disponible</option>
                    </select>

                    <button type="submit">Publier le Post</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>