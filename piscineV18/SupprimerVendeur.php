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

// Configuration de la connexion à la base de données
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "comptes";

// Création de la connexion
$comptesConn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Vérification de la connexion
if ($comptesConn->connect_error) {
    die("Erreur de connexion à la base de données : " . $comptesConn->connect_error);
}

// Vérification si le formulaire a été soumis
if (isset($_POST["pseudo"])) {
    // Récupération du pseudo du vendeur à supprimer
    $pseudo = $_POST["pseudo"];

    // Vérification si le pseudo est renseigné
    if (empty($pseudo)) {
        echo "Veuillez renseigner le pseudo du vendeur à supprimer.";
    } else {
        // Suppression du vendeur dans la table "profil"
        $deleteQuery = "DELETE FROM profil WHERE Pseudo = '$pseudo'";
        $deleteResult = $comptesConn->query($deleteQuery);

        if ($deleteResult) {
            if ($comptesConn->affected_rows > 0) {
                echo "Le vendeur a été supprimé avec succès.";
            } else {
                echo "Le vendeur n'a pas été trouvé.";
            }
        } else {
            echo "Erreur lors de la suppression du vendeur : " . $comptesConn->error;
        }
    }
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
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="pseudo">Pseudo du vendeur :</label>
        <input type="text" id="pseudo" name="pseudo" required><br><br>

        <input type="submit" value="Supprimer vendeur">
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
                    <td>10h - 16h</td>
                </tr>
                <tr>
                    <td>Dimanche</td>
                    <td>Fermé</td>
                </tr>
            </table>
        </div>

        <div style="flex: 1;">
            <h2>Contactez-nous</h2>
            <table>
                <tr>
                    <td>Téléphone</td>
                    <td>01 23 45 67 89</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>contact@agorafrancia.com</td>
                </tr>
                <tr>
                    <td>Fax</td>
                    <td>01 23 45 67 88</td>
                </tr>
                <tr>
                    <td>Suivez-nous</td>
                    <td>
                        <a href="https://www.facebook.com/agorafrancia"><img src="images/facebook.png"
                                                                            alt="Facebook" height="40 px"></a>
                        <a href="https://www.twitter.com/agorafrancia"><img src="images/twitter.png" alt="Twitter"
                                                                             height="40 px"></a>
                        <a href="https://www.instagram.com/agorafrancia"><img src="images/instagram.png"
                                                                              alt="Instagram" height="40 px"></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</section>

<footer>
    <div id="footer-container">
        <div id="footer-logo">
            <img src="images/logo.png" alt="Logo Agora Francia" height="200 px">
        </div>
        <nav>
            <ul>
                <li><a href="Accueil.php">Accueil</a></li>
                <li><a href="CGU.php">Conditions générales d'utilisation</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>
</footer>

</body>
</html>
