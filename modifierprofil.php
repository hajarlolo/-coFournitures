<?php
session_start();
include('connexion.php');

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$id_utilisateur = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si un fichier a été envoyé
    if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['photo_profil'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // Vérifier le type de fichier (image)
        $allowed_types = array('image/jpeg', 'image/png', 'image/gif','image/jpg');
        $file_type = mime_content_type($file_tmp);

        if (in_array($file_type, $allowed_types)) {
            // Déplacer le fichier vers le dossier "uploads"
            $upload_dir = 'uploads/';
            $new_file_name = $id_utilisateur . '_' . basename($file_name);
            $upload_file = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_file)) {
                $sql = "UPDATE utilisateurs SET photo_profil = ? WHERE id = ?";
                $stmt = $connexion->prepare($sql);
                $stmt->execute([$new_file_name, $id_utilisateur]);
                header('Location: moncompte.php');
                exit;
            } else {
                $error_message = "Une erreur s'est produite lors du téléchargement de l'image.";
            }
        } else {
            $error_message = "Le type de fichier n'est pas autorisé.";
        }
    } else {
        $error_message = "Aucun fichier n'a été sélectionné.";
    }
}
?>
