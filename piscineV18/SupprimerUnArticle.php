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

$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, "articles");

if (isset($_POST["bouton1"])) {
    if ($db_found) {
        $ID_article = isset($_POST["ID_article"]) ? $_POST["ID_article"] : "";

        if ($ID_article != "") {
            $sql = "DELETE FROM achatimmediat WHERE ID_article = $ID_article";
            $result = mysqli_query($db_handle, $sql);

            if ($result) {
                echo "<p>Article supprimé avec succès</p>";
                header("Location: Accueil.php");
            } else {
                echo "<p>Erreur lors de la suppression de l'article " . mysqli_error($db_handle) . "</p>";
            }
        } else {
            echo "<p>Veuillez saisir l'ID de l'article à supprimer.</p>";
        }

        $ID_article = isset($_POST["ID_article"]) ? $_POST["ID_article"] : "";

        if ($ID_article != "") {
          $sql = "DELETE FROM achatreduit WHERE ID_article = $ID_article";
          $result = mysqli_query($db_handle, $sql);

          if ($result) {
              echo "<p>Article supprimé avec succès</p>";
              header("Location: Accueil.php");
          } else {
              echo "<p>Erreur lors de la suppression de l'article " . mysqli_error($db_handle) . "</p>";
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
    <title>Supprimer un article</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            padding: 20px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
        }

        label {
            display: inline-block;
            width: 120px;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="submit"] {
            width: 250px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<header>
    <div id="header-container">
      <div id="logo">
        <img src="logo.png" alt="Logo Agora Francia" width="110%">
      </div>

      <script>
          // Fonctions de navigation
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
          function continuerAchats() {
            window.location.href = "affichageArticlesAchatImmediat.php";
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

    <h2 style="text-align: center;">Supprimer un article</h2>
    <form action="SupprimerUnArticle.php" method="post">
        <label for="ID_article">R&eacute;f&eacute;rence de l'article à supprimer:</label>
        <input type="text" id="ID_article" name="ID_article" required><br><br>

        <input type="submit" name="bouton1" value="Supprimer">
    </form>

</body>
</html>
