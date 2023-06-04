<?php
// Démarre la session
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

    ///echo "<p> Statut compte : $utilisateurStatut </p>"

?>

<!DOCTYPE html>
<html>
<head>
    <title>Affichage des éléments</title>
    <!-- Le reste de votre code HTML et CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Style_Accueil.css">
  
</head>
<body>

    
    <header>
        <div id="header-container">
      <div id="logo">
        <img src="images/logo.png" alt="Logo Agora Francia" height="300 px">
      </div>

      <script>
          function bouton_compte() {
            window.location.href = "compte.php";
          }
          function bouton_panier() {
            window.location.href = "panier.php";
          }
          function bouton_accueil() {
            window.location.href = "Accueil.php";
          }
          function bouton_tout_parcourir() {
            window.location.href = "Tout_Parcourir.html";
          }
          function bouton_notifications() {
            window.location.href = "notification.php";
          }

      </script>


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
        <!-- Le reste de votre code pour afficher les éléments -->
        <?php
        // Affichage du nom d'utilisateur
        echo "Bienvenue, " . $username;
        
        // Le reste de votre code pour afficher les éléments
        ?>

        <div class="item-container">
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
        $sql = "SELECT * FROM negociationvendeurclient";
        $result = $conn->query($sql);

        // Vérifier s'il y a des résultats
        if ($result->num_rows > 0) {
            // Afficher les éléments
            while ($row = $result->fetch_assoc()) {
                $prixDebut = $row['PrixDebut'];
                $description = $row['Description'];
                $photo = $row['Photo'];

                // Afficher les données de chaque élément*
                echo "<div class='item'>";
                echo "<h3>Description :</h3>";
                echo "<p>$description</p>";
               echo "<a href='detailsMontre.php?id=" . $row['ID_article'] . "'><div class='item-photo'><img src='$photo' alt='Photo de l'article' height='200px'></div></a>";

                echo "<div class='item-details'>";
                echo "<h3>Prix de départ :</h3>";
                echo "<p>$prix €</p>";
                echo "</div>";
                echo "</div>";

            }
        } else {
            echo "Aucun élément trouvé dans la base de données.";
        }

        // Fermer la connexion à la base de données
        $conn->close();
        ?>
    </div>
    


    </section>
  
    <footer>
       <a href="#">Conditions générales du site</a> | <a href="#">Politique de retours &amp; Remboursements</a>
    <p>
        <small> Droit d’auteur & Copyright © 2023, Agora Francia </small>
    </p>
    </footer>
</body>
</html>
