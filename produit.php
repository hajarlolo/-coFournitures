<?php
session_start();
include('connexion.php');

if (!isset($_GET['id'])) {
    header('Location: moncompte.php');
    exit;
}

$id_produit = $_GET['id'];

$sql_produit = "SELECT * FROM produits WHERE id = ?";
$stmt_produit = $connexion->prepare($sql_produit);
$stmt_produit->execute([$id_produit]);
$produit = $stmt_produit->fetch();

$sql_commentaires = "
    SELECT commentaires.id AS id_commentaire, commentaires.commentaire, commentaires.id_utilisateur, utilisateurs.nom, utilisateurs.prenom 
    FROM commentaires 
    JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id 
    WHERE commentaires.id_produit = ?
";

$stmt_commentaires = $connexion->prepare($sql_commentaires);
$stmt_commentaires->execute([$id_produit]);
$commentaires = $stmt_commentaires->fetchAll();


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $produit['titre']; ?></title>
    <style>
        :root {
            --brun: rgb(90, 68, 58);
            --beige: rgb(255, 245, 207);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--beige);
            margin: 0;
            padding: 0;
        }

        .produit-container {
            max-width: 800px;
            margin: 10px auto;
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px solid var(--brun);
        }

        h2,
        h3 {
            color: var(--brun);
            margin-bottom: 15px;
        }

        p {
            font-size: 16px;
            color: var(--brun);
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid var(--brun);
            text-align: center;
        }

        table thead {
            background-color: var(--brun);
        }

        table thead th {
            color: white;
            padding: 12px;
            border: 1px solid var(--brun);
        }

        table tbody tr:hover {
            background-color: var(--beige);
            transition: background-color 0.3s;
        }

        table tbody tr {
            background-color: white;
        }

        table tbody td {
            padding: 12px;
            color: var(--brun);
            border: 1px solid #ddd;
        }

        form {
            margin-top: 5px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .edit-delete-links{
            display: flex;
            justify-content: center;

        }
        button,
        .messaging-link,
        .edit-delete-links a {
            background-color: var(--brun);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            text-align: center;
            text-decoration: none;
        }

        button:hover,
        .messaging-link:hover,
        .edit-delete-links a:hover {
            background-color: #4b362c;
        }

        .messaging-link {
            display: inline-block;
            text-decoration: none;
        }

        .return-link {
            display: inline-block;
            background-color: var(--brun);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s;
            margin: 5px;
        }

        .return-link:hover {
            background-color: #4b362c;
        }

        /* Style for edit and delete links */
        .edit-delete-links {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }

        .edit-delete-links a {
            background-color: #fff;
            color: var(--brun);
            border: 1px solid var(--brun);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .edit-delete-links a:hover {
            background-color: var(--brun);
            color: white;
        }

        @media (max-width: 600px) {
            .produit-container {
                padding: 20px;
                margin: 20px 10px;
            }

            .button-container {
                flex-direction: column;
                gap: 10px;
            }

            button,
            .messaging-link,
            .return-link {
                width: 90%;
                padding: 10px;
                font-size: 14px;
                margin-left: auto;
                margin-right: auto;
            }
            table{
                width: 100%;
            }

            table thead {
                display: none;
            }

            table,
            tbody,
            tr,
            td {
                display: block;
            }

            table tbody td {
                text-align: left;
                padding: 10px;
                border: none;
                border-bottom: 1px solid #ccc;
            }

            table tbody tr {
                margin-bottom: 10px;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
                background-color: #fff;
            }
        }
    </style>
</head>

<body>

    <a href="acceuil.php" class="return-link">← Retour</a>
    <?php
    $sql_utilisateur = "SELECT * FROM utilisateurs WHERE id = ?";
    $stmt_user = $connexion->prepare($sql_utilisateur);
    $stmt_user->execute([$produit['id_utilisateur']]);
    $utilisateur = $stmt_user->fetch();
    ?>

    <div class="produit-container">
        <h2><?php echo $produit['titre']; ?></h2>
        <p><strong>Catégorie:</strong> <?php echo $produit['categorie']; ?></p>
        <p><strong>Description:</strong> <br><?php echo $produit['description']; ?></p>
        <p><strong>Ville:</strong> <?php echo $produit['ville']; ?></p>
        <p><strong>Quartier:</strong> <?php echo $produit['quartier']; ?></p>
        <p><strong>Propriétaire:</strong>
            <?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?></p>

        <h3>Commentaires</h3>
        <table>
            <thead>
                <tr>
                    <th>Auteur</th>
                    <th>Commentaire</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commentaires as $commentaire): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($commentaire['prenom'] . ' ' . $commentaire['nom']); ?></td>
                        <td>
                            <?php echo html_entity_decode(htmlspecialchars($commentaire['commentaire'])); ?>
                            <?php if (isset($_SESSION['id']) && $_SESSION['id'] == $commentaire['id_utilisateur']): ?>
                                <br>
                                <div class="edit-delete-links">
                                    <a
                                        href="modifier_commentaire.php?id=<?php echo $commentaire['id_commentaire']; ?>&produit=<?php echo $produit['id']; ?>">✏️
                                        Modifier</a>
                                    <a href="supprimer_commentaire.php?id=<?php echo $commentaire['id_commentaire']; ?>&produit=<?php echo $produit['id']; ?>"
                                        onclick="return confirm('Confirmer la suppression ?')">🗑 Supprimer</a>
                                </div><?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <form action="commenter.php?id_produit=<?php echo $produit['id']; ?>" method="POST">
            <div class="button-container">
                <button type="submit">Commenter</button>
                <a href="messagerie.php?id=<?php echo $produit['id_utilisateur']; ?>" class="messaging-link">Envoyer un
                    message au propriétaire</a>
            </div>
        </form>

    </div>

</body>

</html>