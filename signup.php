<?php
include 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $cin = htmlspecialchars($_POST['cin']);
    $ville = htmlspecialchars($_POST['ville']);
    $quartier = htmlspecialchars($_POST['quartier']);

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($mot_de_passe) && !empty($cin)) {
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, CIN, ville, quartier) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connexion->prepare($sql);
        if ($stmt->execute([$nom, $prenom, $email, $mot_de_passe_hash, $cin, $ville, $quartier])) {
            $id = $connexion->lastInsertId();
            $_SESSION['id'] = $id;
            $_SESSION['nom'] = $nom;
            header('Location:acceuil.php');
            exit();
        } else {
            echo "Erreur lors de l'inscription.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Échange Scolaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(255, 245, 207);
            margin: 0;
            color: rgb(90, 68, 58);
            padding: 0;
        }

        .form-container {
            width: 50%;
            margin: 3px auto;
            background-color: #fff;
            padding: 20px;
            padding-top: 1;
            padding-bottom: 1;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-top: 0;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: rgb(135, 106, 92);
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(90, 68, 58);
        }

        p {
            text-align: center;
            margin-bottom: 0;
        }

        a {
            color: #007bff;
        }

        @media screen and (max-width: 768px) {
            .form-container {
                width: 70%;
                margin-top: 5%;
            }
        }

        @media screen and (max-width: 480px) {
            .form-container {
                width: 80%;
                margin-top: 3%;
                padding: 15px;
            }

            input,
            button {
                font-size: 16px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Inscription</h2>
        <form action="signup.php" method="POST">
            <label for="nom">Nom</label>
            <input type="text" name="nom" required>

            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" name="mot_de_passe" required>

            <label for="cin">CIN</label>
            <input type="text" name="cin" required>

            <label for="ville">Ville</label>
            <input type="text" name="ville" required>

            <label for="quartier">Quartier</label>
            <input type="text" name="quartier" required>

            <button type="submit"> S'inscrire</button>
        </form>
        <p>Vous avez déjà un compte ? <a href="login.php">Se connecter</a></p>
    </div>

</body>

</html>