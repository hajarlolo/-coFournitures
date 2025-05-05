<?php
session_start();
include('connexion.php');

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$id_utilisateur = $_SESSION['id'];
$sql_utilisateur = "SELECT * FROM utilisateurs WHERE id = ?";
$stmt = $connexion->prepare($sql_utilisateur);
$stmt->execute([$id_utilisateur]);
$utilisateur = $stmt->fetch();

// Récupérer les produits groupés par catégorie
$sql_produits = "SELECT * FROM produits WHERE id_utilisateur = ? ORDER BY categorie, date_ajout DESC";
$stmt_produits = $connexion->prepare($sql_produits);
$stmt_produits->execute([$id_utilisateur]);
$produits = $stmt_produits->fetchAll();

// Organiser les produits par catégorie
$produits_par_categorie = [];
foreach ($produits as $produit) {
    $categorie = $produit['categorie'];
    if (!isset($produits_par_categorie[$categorie])) {
        $produits_par_categorie[$categorie] = [];
    }
    $produits_par_categorie[$categorie][] = $produit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mon Compte</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
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

        * {
            font-size: 1rem;
        }

        .main-nav {
            background-color: var(--fonce);
            padding: 20px 0;
            text-align: center;
        }

        .main-nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 50px;
            margin: 0;
            padding: 0;
        }

        .main-nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .main-nav ul li a:hover {
            background-color: var(--hover);
            color: #fff8f0;
        }

        .dashboard {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            gap: 20px;
            padding: 20px;
        }

        .profil-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .infos-card {
            align-items: center;
        }

        .infos-card,
        .posts-card {
            max-width: 850px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            display: flex;
        }


        .profile-pic-container {
            margin-right: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .infos-card h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .infos-card p {
            font-size: 1.2rem;
            margin: 15px 0;
        }

        .header-posts {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .btn-ajout {
            background-color: var(--fonce);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-ajout:hover {
            background-color: var(--hover);
        }

        .posts-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 20px;
        }

        .posts-card {
            flex-direction: column;
        }

        .post-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            margin: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .post-card img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }

        .post-card h4 {
            margin: 10px 0 5px;
            color: var(--fonce);
        }

        .categorie-titre {
            margin-top: 30px;
            color: var(--fonce);
            font-size: 1.5rem;
            border-bottom: 2px solid var(--fonce);
            padding-bottom: 5px;
        }

        @media (max-width: 768px) {


            .posts-section {
                grid-template-columns: 1fr;
            }

            .post-card {
                flex-direction: column;
            }

            .infos-card {
                display: flex;
                flex-direction: column;
            }

            .profile-pic-container {
                margin-top: 20px;
                height: auto;
                max-height: 180px;
                margin-right: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .post-card img {
                height: auto;
                max-height: 180px;
                margin-right: 0;
                margin-bottom: 10px;
            }

            .main-nav ul {
                flex-direction: row;
                gap: 0px;
            }

            .main-nav ul li a {
                text-decoration: none;
                color: white;
                font-size: 0.8rem;
            }

            .header-posts {
                font-size: 0.7rem;
            }
        }
    </style>
</head>

<body>

    <nav class="main-nav">
        <ul>
            <li><a href="acceuil.php">Accueil</a></li>
            <li><a href="notifications.php">Notifications</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <section class="profil-section">
            <div class="infos-card">
                <div class="info-content">
                    <h3>Informations personnelles</h3>
                    <p><strong>Nom:</strong> <?php echo $utilisateur['nom']; ?></p>
                    <p><strong>Prénom:</strong> <?php echo $utilisateur['prenom']; ?></p>
                    <p><strong>Email:</strong> <?php echo $utilisateur['email']; ?></p>
                    <p><strong>Ville:</strong> <?php echo $utilisateur['ville']; ?></p>
                    <p><strong>Quartier:</strong> <?php echo $utilisateur['quartier']; ?></p>
                </div>
                <div class="profile-pic-container">
                    <img src="<?php echo $utilisateur['photo_profil'] ? 'uploads/' . $utilisateur['photo_profil'] : 'default_avatar.jpeg'; ?>"
                        alt="Photo de profil" class="profile-pic">
                        <a href="photoprofil.php" >Voir</a>
                </div>
            </div>

            <div class="posts-card">
                <div class="header-posts">
                    <h2>Mes Posts</h2>
                    <a href="creerpost.php" class="btn-ajout">+ Ajouter un Post</a>
                </div>
                <?php foreach ($produits_par_categorie as $categorie => $posts): ?>
                    <div class="categorie-titre"><?php echo htmlspecialchars($categorie); ?></div>
                    <div class="posts-section">
                        <?php foreach ($posts as $produit): ?>
                            <div class="post-card">
                                <img src="images/<?php echo htmlspecialchars($produit['photo']); ?>" alt="Image produit">
                                <div>
                                    <h4><?php echo htmlspecialchars($produit['titre']); ?></h4>
                                    <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($produit['categorie']); ?></p>
                                    <p><strong>Détails :</strong><br><?php echo htmlspecialchars($produit['description']); ?>
                                    </p>
                                    <p><strong>Statut :</strong> <?php echo htmlspecialchars($produit['statut']); ?></p>
                                    <p><strong>Ville :</strong> <?php echo htmlspecialchars($produit['ville']); ?> </p>
                                    <p><strong>Quartier :</strong> <?php echo htmlspecialchars($produit['quartier']); ?></p>
                                    <p><em>Ajouté le : <?php echo htmlspecialchars($produit['date_ajout']); ?></em></p>
                                    <div style="margin-top: 10px;">
                                        <a href="modifierpost.php?id=<?php echo $produit['id']; ?>" class="btn-ajout"
                                            style="background-color:wheat;color:rgb(90, 68, 58);">Modifier</a>
                                        <a href="supprimerpost.php?id=<?php echo $produit['id']; ?>" class="btn-ajout"
                                            style="background-color:wheat;color:rgb(90, 68, 58);"
                                            onclick="return confirm('Confirmer la suppression de ce post ?')">Supprimer</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

</body>

</html>