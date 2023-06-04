<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    // Redirection vers la page de connexion
    header("Location: panierInvite.php");
    exit;
}

$pseudo = $_SESSION['username'];

// Connexion à la base de données "comptes"
$comptesConn = new mysqli("localhost", "root", "", "comptes");

if ($comptesConn->connect_error) {
    die("Échec de la connexion à la base de données 'comptes': " . $comptesConn->connect_error);
}

// ID de l'utilisateur connecté (à obtenir depuis la session ou l'authentification)
$utilisateurID = 0;

// Récupération des informations de l'utilisateur connecté depuis la table "profil"
$utilisateurQuery = "SELECT ID_profil FROM profil WHERE Pseudo = '$pseudo'";
$utilisateurResult = $comptesConn->query($utilisateurQuery);

if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
    $utilisateurRow = $utilisateurResult->fetch_assoc();
    $utilisateurID = $utilisateurRow["ID_profil"];
} else {
    echo "Utilisateur non trouvé.";
}

// Récupération du statut de l'utilisateur connecté depuis la table "profil"
$utilisateurStatut = 0;

$utilisateurQuery = "SELECT Type_compte FROM profil WHERE Pseudo = '$pseudo'";
$utilisateurResult = $comptesConn->query($utilisateurQuery);

if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
    $utilisateurRow = $utilisateurResult->fetch_assoc();
    $utilisateurStatut = $utilisateurRow["Type_compte"];
} else {
    echo "Utilisateur non trouvé.";
}

function Affichage_Panier($utilisateurID)
{
    $articlesConn = new mysqli("localhost", "root", "", "articles");

    if ($articlesConn->connect_error) {
        die("Échec de la connexion à la base de données 'articles': " . $articlesConn->connect_error);
    }

    // Requête pour récupérer tous les articles achetés par l'utilisateur connecté depuis la table "achatimmediat"
    $articlesQuery = "SELECT * FROM achatimmediat WHERE ID_acheteur = $utilisateurID";
    $articlesResult = $articlesConn->query($articlesQuery);

    if ($articlesResult && $articlesResult->num_rows > 0) {
        echo "<style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px lightgray solid;
            padding: 8px;
            border-radius: 4px;
        }
        </style>";
        echo "<table>";
        echo "<tr><th>ID Article</th><th>ID Vendeur</th><th>Nom du Vendeur</th><th>Statut</th><th>Prix</th><th>Photo</th><th>Description</th><th>Action</th>";

        $total = 0;
        $articlesAffiches = array(); // Tableau pour stocker les articles déjà affichés

        while ($articleRow = $articlesResult->fetch_assoc()) {
            // Vérifier si l'article a déjà été affiché
            if (!in_array($articleRow["ID_article"], $articlesAffiches)) {
                $articlesAffiches[] = $articleRow["ID_article"];

                // Récupération des informations de l'article depuis la table "article"
                $articleQuery = "SELECT * FROM article WHERE ID_article = " . $articleRow["ID_article"];
                $articleResult = $articlesConn->query($articleQuery);

                if ($articleResult && $articleResult->num_rows > 0) {
                    $articleRow = $articleResult->fetch_assoc();

                    // Récupération des informations du vendeur depuis la table "profil"
                    $vendeurQuery = "SELECT * FROM profil WHERE ID_profil = " . $articleRow["ID_vendeur"];
                    $vendeurResult = $articlesConn->query($vendeurQuery);

                    if ($vendeurResult && $vendeurResult->num_rows > 0) {
                        $vendeurRow = $vendeurResult->fetch_assoc();

                        // Affichage des informations de l'article
                        echo "<tr>";
                        echo "<td>" . $articleRow["ID_article"] . "</td>";
                        echo "<td>" . $articleRow["ID_vendeur"] . "</td>";
                        echo "<td>" . $vendeurRow["Pseudo"] . "</td>";
                        echo "<td>" . $articleRow["Statut"] . "</td>";
                        echo "<td>" . $articleRow["Prix"] . "€</td>";
                        echo "<td><img src='" . $articleRow["Photo"] . "' width='100' height='100'></td>";
                        echo "<td>" . $articleRow["Description"] . "</td>";
                        echo "<td><a href='recapCommande.php?ID_article=" . $articleRow["ID_article"] . "'>Supprimer</a></td>";
                        echo "</tr>";

                        $total += $articleRow["Prix"];
                    } else {
                        echo "Vendeur non trouvé.";
                    }
                } else {
                    echo "Article non trouvé.";
                }
            }
        }

        echo "</table>";

        // Affichage du total
        echo "<p>Total : " . $total . "€</p>";
    } else {
        echo "Aucun article trouvé dans le panier.";
    }

    $articlesConn->close();
}

// Suppression d'un article du panier
if (isset($_GET['ID_article'])) {
    $articleID = $_GET['ID_article'];

    // Vérification si l'article appartient à l'utilisateur connecté avant de le supprimer
    $verificationQuery = "SELECT * FROM achatimmediat WHERE ID_article = $articleID AND ID_acheteur = $utilisateurID";
    $verificationResult = $comptesConn->query($verificationQuery);

    if ($verificationResult && $verificationResult->num_rows > 0) {
        // Suppression de l'article de la table "achatimmediat"
        $suppressionQuery = "DELETE FROM achatimmediat WHERE ID_article = $articleID AND ID_acheteur = $utilisateurID";
        $suppressionResult = $comptesConn->query($suppressionQuery);

        if ($suppressionResult) {
            echo "Article supprimé avec succès.";
            // Redirection vers la page de récapitulatif de commande après la suppression
            header("Location: recapCommande.php");
            exit;
        } else {
            echo "Échec de la suppression de l'article.";
        }
    } else {
        echo "Cet article ne peut pas être supprimé.";
    }
}
function supprimer_tout_panier($utilisateurID) {
    $articlesConn = new mysqli("localhost", "root", "", "articles");

    if ($articlesConn->connect_error) {
        die("Échec de la connexion à la base de données 'articles': " . $articlesConn->connect_error);
    }

    // Requête pour supprimer tous les articles du panier de l'utilisateur
    $supprimerPanierQuery = "UPDATE achatimmediat SET ID_acheteur = NULL WHERE ID_acheteur = $utilisateurID";

    if ($articlesConn->query($supprimerPanierQuery) === TRUE) {
        echo "Le panier a été vidé avec succès.";
    }
    else {
        echo "Erreur lors de la suppression du panier: " . $articlesConn->error;
    }

    $articlesConn->close();
}


$comptesConn->close();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Récapitulatif de commande</title>
    <link rel="stylesheet" href="Style_Accueil.css">
</head>

<body>
    <h1>Récapitulatif de commande</h1>
    <h3>Bienvenue, <?php echo $pseudo; ?></h3>

    <img src="images/livreur.jpg" alt="Logo Livreur">

    <?php
    Affichage_Panier($utilisateurID);
    ?>

    <p><a href="accueil.php">Retour à l'accueil</a></p>
</body>

</html>
