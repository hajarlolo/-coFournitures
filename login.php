<?php
include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$email]);
    $utilisateur = $stmt->fetch();

    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        session_start();
        $_SESSION['id'] = $utilisateur['id'];
        $_SESSION['nom'] = $utilisateur['nom'];
        $_SESSION['prenom'] = $utilisateur['prenom'];

        header('Location: acceuil.php');

    } else {
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Échange Scolaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(255, 245, 207);
            margin: 0;
            color: rgb(90, 68, 58);
            padding: 0;
        }


        .form-container {
            width: 30%;
            margin: 12% auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
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
        }

        a {
            color: #007bff;
        }

        @media screen and (max-width: 768px) {
            .form-container {
                width: 70%;
                margin-top: 20%;
            }
        }

        @media screen and (max-width: 480px) {
            .form-container {
                width: 80%;
                margin-top: 25%;
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
        <h2>Connexion</h2>

        <?php if (isset($erreur)) {
            echo "<p class='erreur'>$erreur</p>";
        } ?>

        <form action="login.php" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" name="mot_de_passe" required>

            <button type="submit">Se connecter</button>
        </form>
        <p>Vous n'avez pas de compte ? <a href="signup.php">S'inscrire</a></p>
    </div>

</body>

</html>