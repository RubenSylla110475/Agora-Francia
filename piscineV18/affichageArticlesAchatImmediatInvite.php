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


      <<nav style="display: flex; justify-content: center;">
        <ul>
          <li class="white" type="button"><a href="Accueil.php"><b>Accueil</b></a></li>
              <div class="dropdown" type="button">
                  <b>Parcourir</b>
                  <div class="dropdown-content">
                    <a href="https://blog.hubspot.com/">Enchères</a>
                    <a href="affichageArticlesAchatNegociation.php">Négociations</a>
                    <a href="affichageArticlesAchatImmediat.php">Achat immédiat</a>
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
        $sql = "SELECT * FROM AchatImmediat";
        $result = $conn->query($sql);

        // Vérifier s'il y a des résultats
        if ($result->num_rows > 0) {
            // Afficher les éléments
            while ($row = $result->fetch_assoc()) {
                $prix = $row['Prix'];
                $description = $row['Description'];
                $photo = $row['Photo'];

                // Afficher les données de chaque élément*
                echo "<div class='item'>";
                echo "<h3>Description :</h3>";
                echo "<p>$description</p>";
               echo "<a href='detailsMontre.php?id=" . $row['ID_article'] . "'><div class='item-photo'><img src='$photo' alt='Photo de l'article' height='200px'></div></a>";

                echo "<div class='item-details'>";
                echo "<h3>Prix :</h3>";
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
