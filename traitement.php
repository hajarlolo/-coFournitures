<?php
session_start();

include('connexion.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id=$_SESSION['id'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];
    $ville = $_POST['ville'];
    $quartier = $_POST['quartier'];
    $statut = $_POST['statut'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $tmp_name = $_FILES['photo']['tmp_name'];
        $nom_photo = uniqid() . "_" . basename($_FILES['photo']['name']);
        $dossier = "images/";  // Répertoire où les images seront stockées (dossier 'images')

        // Vérification de l'extension
        $extension = strtolower(pathinfo($nom_photo, PATHINFO_EXTENSION));
        $extensions_valides = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extension, $extensions_valides)) {
            if (move_uploaded_file($tmp_name, $dossier . $nom_photo)) {

                $sql = "INSERT INTO produits ( id_utilisateur,titre, description, categorie, photo, ville, quartier, statut)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $connexion->prepare($sql);
                $stmt->execute([ $id,$titre, $description, $categorie, $nom_photo, $ville, $quartier, $statut]);

                header('Location: moncompte.php');
                exit();
            } else {
                echo "❌ Une erreur est survenue lors du téléchargement de l'image.";
            }
        } else {
            echo "❌ Extension non valide. Formats autorisés : jpg, jpeg, png, gif.";
        }
    } else {
        echo "❌ Erreur lors de l’upload de l’image.";
    }
}
?>
