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

    // Récupération des informations de l'utilisateur connecté depuis la table "profil"
    $utilisateurQuery = "SELECT ID_profil FROM profil WHERE Pseudo = '$pseudo'";
    $utilisateurResult = $comptesConn->query($utilisateurQuery);

    if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
        $utilisateurRow = $utilisateurResult->fetch_assoc();
        $utilisateurID = $utilisateurRow["ID_profil"];

        ///echo "L'ID de l'utilisateur '$pseudo' est : $utilisateurID";
    } else {
        echo "Utilisateur non trouvé.";
    }

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


    // Connexion à la base de données "articles"
    

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
            echo "<tr><th>ID Article</th><th>ID Vendeur</th><th>Nom du Vendeur</th><th>Statut</th><th>Prix</th><th>Photo</th><th>Description</th>";
            
            while ($articleRow = $articlesResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$articleRow["ID_article"]."</td>";
                echo "<td>".$articleRow["ID_vendeur"]."</td>";
                echo "<td>".$articleRow["Nom"]."</td>";
                echo "<td>".$articleRow["Notifications"]."</td>";
                echo "<td>".$articleRow["NouveauPrix"]."€</td>";
                echo "<td><img src='".$articleRow["Photo"]."' alt='Photo' width='100' height='150'></td>";
                echo "<td>".$articleRow["Description"]."</td>";
                echo "<td><button onclick=\"supprimerPanier(" . $articleRow['ID_article'] . ")\"><img src='images/poubelle.jpg' alt='Supprimer' width='20' height='20'></button></td>";


                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Panier Vide";
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
        <img src="logo.png" alt="Logo Agora Francia" width="110%">
      </div>

      <script>
          function continuerAchats() {
            window.location.href = "affichageArticlesAchatImmediat.php";
          }
          
          function supprimerPanier(articleID) {
            window.location.href = "supprimerPanier.php?articleID=" + articleID;
            
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
    <h2>Votre Panier</h2>
    <div id="Panier">
      <form action="panier.php" method="post">
        <h3>Articles de <?php echo $pseudo ?></h3>
        <?php Affichage_Panier($utilisateurID); ?>
      </form>
    </div>

    <button class="custom-button" onclick="window.location.href = 'achat.php'">Procéder au paiement</button>
		<button class="custom-button" onclick="continuerAchats()">Continuer mes achats</button>
  </section>
  
  <footer>
    <a href="#">Conditions générales du site</a> | <a href="#">Politique de retours &amp; Remboursements</a>
    <p>
        <small> Droit d’auteur & Copyright © 2023, Agora Francia </small>
    </p>
  </footer>
</body>
</html>