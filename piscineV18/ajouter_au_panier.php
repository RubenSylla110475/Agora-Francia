<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    // Redirection vers la page de connexion
    header("Location: login.html");
    exit;
}

function Nouvelle_Notif($ID_Profil, $Message)
{
    $comptesConn = new mysqli("localhost", "root", "", "comptes");

    if ($comptesConn->connect_error) {
        die("Échec de la connexion à la base de données 'comptes': " . $comptesConn->connect_error);
    }

    $sql = "SELECT COUNT(*) AS total FROM notifications";
    $result = $comptesConn->query($sql);

    $data = mysqli_fetch_assoc($result);
    $compteur = $data["total"] + 1;

    $Message = $comptesConn->real_escape_string($Message);

    $sql = "INSERT INTO notifications(ID_Notif, ID_Profil, Messages, Temps) VALUES ('$compteur', '$ID_Profil', '$Message', NOW())";

    if ($comptesConn->query($sql) === TRUE) {
        echo "Nouvelle notification créée avec succès !";
    } else {
        echo "Erreur: " . $sql . "<br>" . $comptesConn->error;
    }

}

if (isset($_SESSION['username'])) {
    $pseudo = $_SESSION['username'];
} else {
    echo "Nom d'utilisateur non trouvé.";
    exit;
}

$utilisateurID = null; // Déclaration et initialisation de la variable
// Récupération des informations de l'article
if (isset($_POST['articleID'])) {
    $articleID = $_POST['articleID'];
} else {
    echo "ID d'article non spécifié.";
    exit;
}

$comptesConn = new mysqli("localhost", "root", "", "comptes");

if ($comptesConn->connect_error) {
    die("Échec de la connexion à la base de données 'comptes': " . $comptesConn->connect_error);
}

// ID de l'utilisateur connecté (à obtenir depuis la session ou l'authentification)

// Récupération des informations de l'utilisateur connecté depuis la table "profil"
$utilisateurQuery = "SELECT ID_profil FROM profil WHERE Pseudo = '$pseudo'";
$utilisateurResult = $comptesConn->query($utilisateurQuery);

if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
    $utilisateurRow = $utilisateurResult->fetch_assoc();
    $utilisateurID = $utilisateurRow["ID_profil"];
} else {
    echo "Erreur lors de la récupération de l'ID du profil : " . $comptesConn->error;
    exit;
}

$conn = new mysqli("localhost", "root", "", "articles");

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

$sql = "SELECT * FROM achatimmediat WHERE ID_article = $articleID";
$result = $conn->query($sql);

// On retrouve la description de l'article
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $description = $row['Description'];
    }
} else {
    echo "Aucun article trouvé.";
}

$sql = "UPDATE achatimmediat SET ID_acheteur = $utilisateurID WHERE ID_article = $articleID";

if ($conn->query($sql) === TRUE) {
    echo "done";
    $Message = "L'article : " . $description . " a été ajouté au panier !";
    Nouvelle_Notif($utilisateurID, $Message);
    header("Location: panier.php");
} else {
    echo "Erreur lors de la mise à jour de la base de données: " . $conn->error;
}

$conn->close();

// Redirection vers une page de confirmation ou autre action appropriée

exit;
?>
