<?php
session_start();
include('connexion.php');

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id_post = $_GET['id'];
    $id_utilisateur = $_SESSION['id'];

    // Vérifier que le post appartient à l'utilisateur
    $stmt = $connexion->prepare("SELECT * FROM produits WHERE id = ? AND id_utilisateur = ?");
    $stmt->execute([$id_post, $id_utilisateur]);
    $post = $stmt->fetch();

    if ($post) {
        // Supprimer le fichier image
        if (!empty($post['photo']) && file_exists('images/' . $post['photo'])) {
            unlink('images/' . $post['photo']);
        }

        // Supprimer de la base
        $stmt = $connexion->prepare("DELETE FROM produits WHERE id = ?");
        $stmt->execute([$id_post]);
    }
}

header('Location:moncompte.php'); // Redirige vers le tableau de bord
exit;
