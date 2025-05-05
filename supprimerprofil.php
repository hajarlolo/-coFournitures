<?php
session_start();
include('connexion.php');

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$id_utilisateur = $_SESSION['id'];

if (isset($_GET['id']) && $_GET['id'] == $id_utilisateur) {
    $sql = "SELECT photo_profil FROM utilisateurs WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id_utilisateur]);
    $utilisateur = $stmt->fetch();
    $photo_profil = $utilisateur['photo_profil'];

    // Supprimer le fichier de la photo de profil
    if ($photo_profil && file_exists('uploads/' . $photo_profil)) {
        unlink('uploads/' . $photo_profil);
    }

    // Mettre à jour la photo de profil avec la valeur par défaut
    $sql = "UPDATE utilisateurs SET photo_profil = 'default_avatar.jpeg' WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id_utilisateur]);

    header('Location: moncompte.php');
    exit;
} else {
    header('Location: moncompte.php');
    exit;
}
?>
