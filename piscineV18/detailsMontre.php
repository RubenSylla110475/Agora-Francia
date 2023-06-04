<?php

session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    // Redirection vers la page de connexion
    header("Location: login.html");
    exit;
}

// Récupération du nom d'utilisateur
$username = $_SESSION['username'];

$comptesConn = new mysqli("localhost", "root", "", "comptes");

if ($comptesConn->connect_error) {
    die("Échec de la connexion à la base de données 'comptes': " . $comptesConn->connect_error);
}

// ID de l'utilisateur connecté (à obtenir depuis la session ou l'authentification)

// Récupération des informations de l'utilisateur connecté depuis la table "profil"
$utilisateurQuery = "SELECT Type_compte FROM profil WHERE Pseudo = '$username'";
$utilisateurResult = $comptesConn->query($utilisateurQuery);

if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
    $utilisateurRow = $utilisateurResult->fetch_assoc();
    $utilisateurStatut = $utilisateurRow["Type_compte"];

    ///echo "L'ID de l'utilisateur '$username' est : $utilisateurID";
} else {
    echo "Utilisateur non trouvé.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Affichage des éléments</title>
    <link rel="stylesheet" href="Style_Accueil.css">
    <style>
        .buy-button {
            background-color: #B2935B;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .buy-button:hover {
            background-color: #824d2c;
        }
    </style>
</head>
<body>
    <header>
        <div id="header-container">
            <div id="logo">
                <img src="images/logo.png" alt="Logo Agora Francia" height="300 px">
            </div>
            <nav style="display: flex; justify-content: center;">
            <ul>
                <li class="white" type="button"><a href="Accueil.php"><b>Accueil</b></a></li>
                <div class="dropdown" type="button">
                    <b>Parcourir</b>
                    <div class="dropdown-content">
                        <a href="affichageArticlesAchatEnchere.php">Enchères</a>
                        <a href="affichageArticlesAchatNegociation.php">Négociations</a>
                        <a href="affichageArticlesAchatImmediat.php"> Achat immédiat </a>
                        <?php
                        if ($utilisateurStatut == 3 || $utilisateurStatut == 2) {
                            echo '<a href="AjouterUnArticle.php">Mettre en Vente</a>';
                        }
                          if ($utilisateurStatut == 2) {
                            echo '<a href="SupprimerUnArticleVendeur.php">Supprimer un article</a>';
                        }
                         if ($utilisateurStatut == 3) {
                            echo '<a href="SupprimerUnArticle.php">Supprimer un article</a>';
                        }
                          
                         if ($utilisateurStatut == 3) {
                            echo '<a href="AjoutVendeur.php">Ajout vendeur</a>';
                        }
                          if ($utilisateurStatut == 3) {
                            echo '<a href="SupprimerVendeur.php">Suppression vendeur</a>';
                        }
                        ?>
                    </div>
                </div>

                <li class="white" type="button"><a href="notification.php"><b>Notifications</b></a></li>
                <li class="white" type="button"><a href="panier.php"><b>panier</b></a></li>
                <li class="white" type="button"><a href="compte.php"><b>compte</b></a></li>
            </ul>
        </nav>
        </div>
    </header>

    <section>
        <div class="item-container">
            <?php
            // Démarrer une nouvelle session ou reprendre une session existante
            // Démarrer une nouvelle session ou reprendre une session existante
            ///echo "<p> Statut compte : $utilisateurStatut </p>"

            // Vérifiez si le paramètre d'ID de l'article est présent dans l'URL
            if (isset($_GET['id'])) {
                $articleID = $_GET['id'];

                // Vous pouvez maintenant récupérer les informations de l'article correspondant à l'ID et les afficher
                // par exemple, en exécutant une requête SQL avec la variable $articleID
                // Assurez-vous de prendre des mesures de sécurité appropriées (ex: requête préparée) pour éviter les attaques par injection SQL.
                // Voici un exemple de requête :

                // Connexion à la base de données (vous devez ajuster les paramètres selon votre configuration)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "articles";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Vérifier la connexion à la base de données
                if ($conn->connect_error) {
                    die("Échec de la connexion à la base de données: " . $conn->connect_error);
                }

                // Requête de sélection pour récupérer les informations de l'article correspondant à l'ID
                $sql = "SELECT * FROM AchatImmediat WHERE ID_article = $articleID";
                $result = $conn->query($sql);

                // Vérifier s'il y a des résultats
                if ($result->num_rows > 0) {
                    // Afficher les informations détaillées de l'article
                    while ($row = $result->fetch_assoc()) {
                        $prix = $row['NouveauPrix'];
                        $description = $row['Description'];
                        $photo = $row['Photo'];

                        echo "<div>";
                        echo "<div style='text-align: center;'>";
                        echo "<div style='text-align: center;'>";
                        echo "<img src='$photo' alt='Photo de l'article' height='200px'>";
                        echo "<h3>Description :</h3>";
                        echo "<p>$description</p>";
                        echo "<p>Prix: $prix €</p>";
                        echo "<p>Référence article : $articleID</p>"; // Afficher l'ID de l'article
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "Aucun article trouvé.";
                }

                // Fermer la connexion à la base de données
                $conn->close();
            } else {
                echo "ID d'article non spécifié.";
            }

            function Nouvelle_Notif($ID_Profil,$Message)
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
            ?>

            <div style='text-align: center;'>
                <form method="POST" action="ajouter_au_panier.php">
                    <input type="hidden" name="articleID" value="<?php echo $articleID; ?>">
                    <button class="buy-button" type="submit">Ajouter au panier</button>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <a href="#">Conditions générales du site</a> | <a href="#">Politique de retours &amp; Remboursements</a>
        <p>
            <small> Droit d’auteur &amp; Copie; 2023, Agora Francia </small>
        </p>
    </footer>
</body>

</html>
