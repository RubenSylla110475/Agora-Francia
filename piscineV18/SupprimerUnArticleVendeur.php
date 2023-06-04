

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


// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    // Redirection vers la page de connexion
    header("Location: login.html");
    exit;
}

$pseudo = $_SESSION['username'];

// Connexion à la base de données "comptes"
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
    $ID_Vendeur = $utilisateurRow["ID_profil"];

    // Affiche l'ID du vendeur
    //echo "L'ID de l'utilisateur '$pseudo' est : $ID_Vendeur";
} else {
    echo "Utilisateur non trouvé.";
}

$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, "articles");

if (isset($_POST["bouton1"])) {
    if ($db_found) {
        $ID_article = isset($_POST["ID_article"]) ? $_POST["ID_article"] : "";

        if ($ID_article != "" ) {
            // Requête pour récupérer l'ID_vendeur correspondant à l'ID_article
            $sql = "SELECT ID_vendeur FROM achatimmediat WHERE ID_article = $ID_article";
            $result = mysqli_query($db_handle, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $vendeurId = $row['ID_vendeur'];

                // Vérifie si l'utilisateur est le propriétaire de l'article
                if ($vendeurId == $ID_Vendeur) {
                    // Requête pour supprimer l'article
                    $sql = "DELETE FROM achatimmediat WHERE ID_article = $ID_article";
                    $result = mysqli_query($db_handle, $sql);

                    if ($result) {
                        echo "<p>Article supprimé avec succès</p>";
                        header("Location: Accueil.php");
                    } else {
                        echo "<p>Erreur lors de la suppression de l'article " . mysqli_error($db_handle) . "</p>";
                    }
                } else {
                    echo "<p>Vous n'êtes pas autorisé à supprimer cet article.</p>";
                }
            } else {
                echo "<p>Article non trouvé.</p>";
            }
        } else {
            echo "<p>Veuillez saisir l'ID de l'article à supprimer.</p>";
        }
    } else {
        echo "<p>Database not found</p>";
    }
}

mysqli_close($db_handle);






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
                            echo '<a href="SupprimerUnArticle.php">test</a>';
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
   <!-- Formulaire pour saisir l'ID de l'article à supprimer -->
<form action="" method="post">
    <label for="ID_article">Référence de l'article à supprimer:</label>
    <input type="text" name="ID_article" id="ID_article" required>
    <input type="submit" name="bouton1" value="Supprimer">
</form>


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
                        <td>: 9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Mardi</td>
                        <td>: 9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Mercredi</td>
                        <td>: 9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Jeudi</td>
                        <td>: 9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Vendredi</td>
                        <td>: 9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Samedi</td>
                        <td>: 9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Dimanche</td>
                        <td>: Fermé</td>
                    </tr>
                </table>
            <h4>Nous Contacter</h4>
                <p>Par téléphone : +33 (0)1 23 45 67 89</p>
                <p>Par mail : AgoraFrancia@edu.ece.fr</p>
        </div>
        <div style="flex: 1;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41988.09853920827!2d2.224624156951904!3d48.87239311228893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66de0a67db16b%3A0x528689fff94f3c92!2sPublications%20Agora%20France!5e0!3m2!1sfr!2sfr!4v1685739640007!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    

</section>

<footer>
    <a href="conditions.html">Conditions générales du site</a> | <a href="#">Politique de retours &amp; Remboursements</a>
    <p>
        <small> Droit d’auteur &amp; Copyright © 2023, Agora Francia
        </small>
    </p>
</footer>
</body>
</html>