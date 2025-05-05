<?php
session_start();
include('connexion.php');

if (!isset($_SESSION['id'])) {
    header('Location:signup.php');
    exit();
}
if (!isset($_SESSION['id'])) {
    header('Location:login.php');
    exit();
}


// Récupérer tous les produits
$sql_tous_produits = "SELECT * FROM produits";
$stmt_tous_produits = $connexion->prepare($sql_tous_produits);
$stmt_tous_produits->execute();
$tous_produits = $stmt_tous_produits->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Produits - Notre Association</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: rgb(255, 245, 207);
        }

        header {
            background-color: rgb(90, 68, 58);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        .menu-buttons a {
            background-color: #ffffff;
            color: rgb(90, 68, 58);
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: bold;
            margin-left: 10px;
            transition: background 0.3s;
            border: 2px solid #ffffff;
        }

        .menu-buttons a:hover {
            background-color: rgb(255, 245, 207);
        }

        .temoignages {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: rgb(90, 68, 58);
        }

        .temoignage-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
        }

        .temoignage-card {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            width: 100%;
            max-width: 900px;
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .temoignage-image {
            flex: 1;
            max-width: 300px;
            margin-right: 20px;
        }

        .temoignage-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
        }

        .temoignage-info {
            flex: 2;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (max-width: 768px) {
            .temoignage-card {
                flex-direction: column;
            }

            .temoignage-image {
                margin-right: 0;
                margin-bottom: 15px;
                max-width: 100%;
            }
        }

        .temoignage-card p {
            margin-top: 0px;
        }

        .temoignage-card h3 {
            color: rgb(90, 68, 58);
            text-decoration: underline;
            margin-top: 0;
        }

        .boutons-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-action {
            flex: 1;
            text-align: center;
            background-color: rgb(255, 245, 207);
            color: rgb(90, 68, 58);
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-action:hover {
            background-color: rgb(90, 68, 58);
            color: rgb(255, 245, 207);
        }

        @media (max-width: 768px) {
    .temoignage-card {
        flex-direction: column;
    }

    .temoignage-image {
        margin-right: 0;
        margin-bottom: 15px;
        max-width: 100%;
    }
}
    </style>
</head>

<body>

    <header>
        <div class="logo">ÉcoFournitures </div>
        <div class="menu-buttons">
            <a href="moncompte.php">Mon compte</a>
            <a href="logout.php">Déconnexion</a>
        </div>
    </header>

    <section class="temoignages">
        <h2>Liste des Produits Disponibles</h2>
        <div class="temoignage-container">
            <?php if (!empty($tous_produits)): ?>
                <?php foreach ($tous_produits as $t): ?>

                    <div class="temoignage-card">
                        <div class="temoignage-image">
                            <img src="images/<?php echo htmlspecialchars($t['photo']); ?>" alt="Image du produit">
                        </div>
                        <div class="temoignage-info">
                            <h3><?php echo htmlspecialchars($t['titre']); ?></h3>
                            <p><strong>Catégorie:</strong> <?php echo htmlspecialchars($t['categorie']); ?></p>
                            <p><strong>Description:</strong><br> <?php echo htmlspecialchars($t['description']); ?></p>
                            <p><strong>Ville:</strong> <?php echo htmlspecialchars($t['ville']); ?></p>
                            <p><strong>Quartier:</strong> <?php echo htmlspecialchars($t['quartier']); ?></p>
                            <p><strong>Statut:</strong> <?php echo htmlspecialchars($t['statut']); ?></p>
                            <p><strong>Date d'ajout:</strong> <?php echo htmlspecialchars($t['date_ajout']); ?></p>
                            <div class="boutons-actions">
                                <a href="produit.php?id=<?php echo $t['id']; ?>" class="btn-action">Voir</a>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun produit pour le moment... 😢</p>
            <?php endif; ?>
        </div>
    </section>

</body>

</html>