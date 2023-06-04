<?php
// Démarre la session
session_start();

if (!isset($_SESSION['username'])) {
    // Redirection vers la page de connexion
    $username = NULL;

    $utilisateurStatut = 0;
} else {
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

    ///echo "<p> Statut compte : $utilisateurStatut </p>"
}


// Set the cookie with the username
if (!isset($_COOKIE['username'])) {
    setcookie("username", $username, time() + (86400 * 30), "/"); // Expire in 30 days
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Style_Accueil.css">
    <title>Agora Francia - Vente de montres</title>
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
    <table cellpadding="15px">
        <tr>
            <td width="45%">
                <h2>L'histoire de l'horlogerie</h2>
            </td>
            <td width=50% >
                <h2>VENTES FLASH SPECIALES FETE DES MAMANS !</h2>
            </td>
        </tr>
        <tr>
            <td>
                <p>Bienvenue sur <b>Agora Francia</b>, votre destination en ligne pour les montres de luxe les plus raffinées.<br><br> 
                Que vous soyez passionné par l'horlogerie ou que vous recherchiez une pièce unique pour compléter votre style, notre site de commerce en ligne est là pour répondre à tous vos besoins.<br> 
                Découvrez notre vaste sélection de montres allant des classiques intemporelles aux créations contemporaines les plus audacieuses. Avec une attention méticuleuse portée aux détails et une qualité exceptionnelle, chaque montre proposée chez Agora Francia incarne l'élégance et l'exclusivité. <br><br>
                Plongez dans le monde des montres de luxe avec Agora Francia et laissez-nous vous aider à trouver la montre parfaite qui reflétera votre style et votre individualité.</p>
            </td>
            <td>
                <p><b>Profitez de remises exceptionelles spécialement conçues pour l'occasion.</b></p>
                <?php
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

                    // Requête de sélection pour récupérer tous les éléments de la table
                    $sql = "SELECT * FROM achatReduit";
                    $result = $conn->query($sql);

                    // Vérifier s'il y a des résultats
                    if ($result->num_rows > 0) {
                        // Afficher les éléments
                        while ($row = $result->fetch_assoc()) {
                            $prix = $row['Prix'];
                            $description = $row['Description'];
                            $photo = $row['Photo'];
                            $NouveauPrix=$row['PrixReduit'];

                            // Afficher les données de chaque élément*
                            echo "<div class='item'>";
                            echo "<h3>Description :</h3>";
                            echo "<p>$description</p>";
                           echo "<a href='detailsMontre.php?id=" . $row['ID_article'] . "'><div class='item-photo'><img src='$photo' alt='Photo de l'article' height='200px'></div></a>";

                            echo "<div class='item-details'>";
                            echo "<h3>Prix :</h3>";
                            echo "<p><strike>$prix €</strike></p>";
                            echo "<h3>Prix Remsié:</h3>";
                            echo "<p>$NouveauPrix €</p>";
                            echo "</div>";
                            echo "</div>";

                        }
                    } else {
                        echo "Aucun élément en promotion actuellement.";
                    }

                    // Fermer la connexion à la base de données
                    $conn->close();
                    ?>
            </td>
        </tr>
            
            
    </table>
    
    
    
</section>

<section>
    
    <div style="display: flex;">
        <div style="flex: 1;">
            <h2>Où nous trouver ?</h2>
                <table>
                    <tr>
                        <td>116 bis Av. des Champs-Élysées</td>
                    </tr>
                    <tr>
                        <td>75008 Paris</td>
                    </tr>
                    <tr>
                        <td>France</td>
                    </tr>
                </table>
            <h3>Horaires d'ouverture</h3>
                <table>
                    <tr>
                        <td>Lundi</td>
                        <td>9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Mardi</td>
                        <td>9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Mercredi</td>
                        <td>9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Jeudi</td>
                        <td>9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Vendredi</td>
                        <td>9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Samedi</td>
                        <td>9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Dimanche</td>
                        <td>Fermé</td>
                    </tr>
                </table>
            <h4>Nous Contacter</h4>
                <p>Par téléphone : 01 23 45 67 89</p>
                <p>Par mail : AgoraFrancia@edu.ece.fr</p>
        </div>
        <div style="flex: 1;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41988.09853920827!2d2.224624156951904!3d48.87239311228893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66de0a67db16b%3A0x528689fff94f3c92!2sPublications%20Agora%20France!5e0!3m2!1sfr!2sfr!4v1685739640007!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    

</section>

<footer>
    <a href="#">Conditions générales du site</a> | <a href="#">Politique de retours &amp; Remboursements</a>
    <p>
        <small> Droit d’auteur &amp; Copyright © 2023, Agora Francia
        </small>
    </p>
</footer>
</body>
</html>