<?php
    // Démarre la session
    session_start();

    // Vérification si l'utilisateur est connecté
    if (!isset($_SESSION['username'])) {
        // Redirection vers la page de connexion
        header("Location: notificationInvite.php");
        exit;
    }

    $pseudo = $_SESSION['username'];

    $comptesConn = new mysqli("localhost", "root", "", "comptes");

    if ($comptesConn->connect_error) {
        die("Échec de la connexion à la base de données 'comptes': " . $comptesConn->connect_error);
    }

    // ID de l'utilisateur connecté (à obtenir depuis la session ou l'authentification)

    // Récupération des informations de l'utilisateur connecté depuis la table "profil"
    $utilisateurQuery = "SELECT Type_compte FROM profil WHERE Pseudo = '$pseudo'";
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Style_Accueil.css">
  <title>Agora Francia - Vente de montres</title>
</head>

<body>
  <header>
    <div id="header-container">
      <div id="logo">
        <img src="logo.png" alt="Logo Agora Francia" width="110%">
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
    <h2>Vos Notifications</h2>
    <div id="Notif">
      <form action="notification.php" method="post">
        <table>
        <?php
            // Connexion à la base de données (vous devez ajuster les paramètres selon votre configuration)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "comptes";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Vérifier la connexion à la base de données
                if ($conn->connect_error) {
                    die("Échec de la connexion à la base de données: " . $conn->connect_error);
                }

                // Utilisation de la fonction pour afficher la description du dernier article mis dans le panier de l'acheteur connecté
                $pseudo = $_SESSION['username']; // Supposons que l'ID de l'acheteur soit stocké dans $_SESSION['username']

                $utilisateurQuery = "SELECT ID_profil FROM profil WHERE Pseudo = '$pseudo'";
                $utilisateurResult = $comptesConn->query($utilisateurQuery);

                if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
                    $utilisateurRow = $utilisateurResult->fetch_assoc();
                    $utilisateurID = $utilisateurRow["ID_profil"];

                    ///echo "L'ID de l'utilisateur '$pseudo' est : $utilisateurID";
                } else {
                    echo "Utilisateur non trouvé.";
                }

                $articlesQuery = "SELECT * FROM notifications WHERE ID_Profil = '$utilisateurID'";
                $articlesResult = $conn->query($articlesQuery);

                if ($articlesResult && $articlesResult->num_rows > 0) {

                  echo "<b>Bonjour " . $pseudo . " !" . "</b>". "<br>" . "<br>";
                  
                  while ($articleRow = $articlesResult->fetch_assoc()) {

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
                    echo "<tr><th>Message</th><th>Heure</th>";

                    echo "<tr>";
                    echo "<td>".$articleRow["Messages"]."</td>";
                    echo "<td>".$articleRow["Temps"]."</td>";
                    echo "</tr>";
                  }
                  echo "</table>";
              } else {
                  echo "Aucun Notifications.";
              }
        ?>

        </table>
      </form>
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