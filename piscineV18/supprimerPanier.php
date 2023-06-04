<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    // Redirection vers la page de connexion
    header("Location: panierInvite.php");
    exit;
}

// Vérification si l'ID de l'article est fourni
if (!isset($_GET['articleID'])) {
    echo "ID de l'article manquant.";
    exit;
}

$articleID = $_GET['articleID'];

// Connexion à la base de données "comptes"
$comptesConn = new mysqli("localhost", "root", "", "comptes");

if ($comptesConn->connect_error) {
    die("Échec de la connexion à la base de données 'comptes': " . $comptesConn->connect_error);
}

// ID de l'utilisateur connecté (à obtenir depuis la session ou l'authentification)
$pseudo = $_SESSION['username'];

// Récupération de l'ID de l'utilisateur connecté depuis la table "profil"
$utilisateurQuery = "SELECT ID_profil FROM profil WHERE Pseudo = '$pseudo'";
$utilisateurResult = $comptesConn->query($utilisateurQuery);

if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
    $utilisateurRow = $utilisateurResult->fetch_assoc();
    $utilisateurID = $utilisateurRow["ID_profil"];

    // Connexion à la base de données "articles"
    $articlesConn = new mysqli("localhost", "root", "", "articles");

    if ($articlesConn->connect_error) {
        die("Échec de la connexion à la base de données 'articles': " . $articlesConn->connect_error);
    }

    // Suppression de l'article du panier de l'utilisateur
// Suppression de l'article du panier de l'utilisateur
    $suppressionQuery = "UPDATE achatimmediat SET ID_acheteur = 0 WHERE ID_article = $articleID";
    if ($articlesConn->query($suppressionQuery) === TRUE) {
        echo "L'article a été supprimé du panier avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'article du panier : " . $articlesConn->error;
    }


    $articlesConn->close();
} else {
    echo "Utilisateur non trouvé.";
}

$comptesConn->close();
?>
