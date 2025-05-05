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
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo de profil</title>
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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .profile-pic-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 500px;
            width: 50%;
        }

        .profile-pic {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
        }

        form {
            width: 100%;
            border: 2px solid rgb(90, 68, 58);
            border-radius: 10px;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }

        .info-content {
            width: 50%;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .info-content h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .btn-ajout {
            background-color: var(--fonce);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-ajout:hover {
            background-color: var(--hover);
        }

        @media (max-width: 768px) {
            .profile-pic-container {
                padding: 20px;
            }

            .profile-pic {
                width: 120px;
                height: 120px;
            }

            .info-content h3 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <h1>Photo de profil</h1>
    <div class="profile-pic-container">
        <img src="<?php echo $utilisateur['photo_profil'] ? 'uploads/' . $utilisateur['photo_profil'] : 'default_avatar.jpeg'; ?>"
            alt="Photo de profil" class="profile-pic">
    </div>
    <div class="info-content">
        <h3>Modifier la photo de profil</h3>

        <form class="modifier" action="modifierprofil.php" method="post" enctype="multipart/form-data">
            <input type="file" name="photo_profil" required>
            <button type="submit" class="btn-ajout">Mettre à jour</button>
        </form>

        <a href="supprimerprofil.php?id=<?php echo $utilisateur['id']; ?>" class="btn-ajout"
            onclick="return confirm('Voulez-vous vraiment supprimer votre photo de profil ?')">Supprimer la photo de
            profil</a>
    </div>
    <a href="moncompte.php" class="btn-ajout">← Retour</a>
</body>

</html>