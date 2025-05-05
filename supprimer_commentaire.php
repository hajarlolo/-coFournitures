<?php
session_start();
include('connexion.php');

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: signin.php");
    exit;
}

// Récupère l'ID du commentaire et du produit
if (!isset($_GET['id']) || !isset($_GET['produit'])) {
    header("Location: acceuil.php");
    exit;
}

$id_commentaire = $_GET['id'];
$id_produit = $_GET['produit'];

// Vérifie que le commentaire appartient bien à l'utilisateur
$sql = "SELECT * FROM commentaires WHERE id = ?";
$stmt = $connexion->prepare($sql);
$stmt->execute([$id_commentaire]);
$commentaire = $stmt->fetch();

if (!$commentaire || $commentaire['id_utilisateur'] != $_SESSION['id']) {
    echo "Accès non autorisé.";
    exit;
}

// Suppression du commentaire
$delete = "DELETE FROM commentaires WHERE id = ?";
$stmt = $connexion->prepare($delete);
$stmt->execute([$id_commentaire]);

// Redirige vers la page du produit
header("Location: produit.php?id=$id_produit");
exit;
?>
