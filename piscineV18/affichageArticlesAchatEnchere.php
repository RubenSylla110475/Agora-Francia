<?php
// Démarre la session
date_default_timezone_set('Europe/Paris');

session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    // Redirection vers la page de connexion
    header("Location: affichageArticlesAchatImmediatInvite.php");
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

    // Récupération des informations de l'utilisateur connecté depuis la table "profil"
    $utilisateurQuery = "SELECT ID_profil FROM profil WHERE Pseudo = '$username'";
    $utilisateurResult = $comptesConn->query($utilisateurQuery);

    if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
        $utilisateurRow = $utilisateurResult->fetch_assoc();
        $utilisateurID = $utilisateurRow["ID_profil"];

        ///echo "L'ID de l'utilisateur '$pseudo' est : $utilisateurID";
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

    <script>

        function afficherHeure() {
            var date = new Date();
            var heure = date.getHours();
            var minutes = date.getMinutes();
            var secondes = date.getSeconds();
            
            var heureTexte = heure + ':' + minutes + ':' + secondes;
            
            document.getElementById('heure').innerHTML = heureTexte;
        }

        function updateCountdown(elementId, endTime) {
            var countdownElement = document.getElementById(elementId);
            var currentTime = Math.floor(Date.now() / 1000);
            var timeLeft = endTime - currentTime;
      
            if (timeLeft < 0) {
                // L'enchère est terminée
                countdownElement.innerHTML = "L'enchère est terminée.";
            } else {
                // Calcul des jours, heures, minutes et secondes restants
                var days = Math.floor(timeLeft / (60 * 60 * 24));
                var hours = Math.floor((timeLeft % (60 * 60 * 24)) / (60 * 60));
                var minutes = Math.floor((timeLeft % (60 * 60)) / 60);
                var seconds = timeLeft % 60;
        
                // Met à jour l'élément HTML correspondant
                countdownElement.innerHTML = "Temps restant de l'enchère : " + hours + "h " + minutes + "m " + seconds + "s";
            }
        }

        // Récupère tous les éléments de compte à rebours et met à jour le temps restant
        var countdownElements = document.getElementsByClassName("countdown");
        for (var i = 0; i < countdownElements.length; i++) {
            var element = countdownElements[i];
            var endTime = element.getAttribute("data-end-time");
            updateCountdown(element.id, endTime);
        }

        // Met à jour le compte à rebours toutes les secondes
        setInterval(function() {
            for (var i = 0; i < countdownElements.length; i++) {
                var element = countdownElements[i];
                var endTime = element.getAttribute("data-end-time");
                updateCountdown(element.id, endTime);
            }
        }, 1000);
    
        setInterval(afficherHeure, 1000); // Actualise l'heure chaque seconde

    </script>

    <style>
        .encheresJour {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            width: 600px; /* Ajustez la largeur selon vos besoins */
        }

        .encheresJour-image {
            width: 200px; /* Ajustez la taille de l'image selon vos besoins */
            height: auto;
        }

        .encheresJour-details {
            display: flex;
            flex-direction: column;
            margin-left: 20px; /* Ajustez la marge gauche selon vos besoins */
            font-size: 18px; /* Ajustez la taille de police selon vos besoins */
        }

        .encheresJour-details p {
            margin: 5px 0; /* Ajustez la marge selon vos besoins */
        }

        .countdown {
        /* Styles du countdown par défaut */
        }

        .countdown-small {
            font-size: 12px; /* Taille de police plus petite */
        }

        .countdown-red {
            color: red; /* Couleur du texte en rouge */
        }
        
        #Somme{
            width: 100%;
            text-align: center;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #333333;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        #Somme:hover {
            background-color: #4CAF50;
        }

        #Somme:active {
            background-color: #3e8e41;
            transform: translateY(4px);
        }

        #Somme:focus {
            outline: none;
        }

        #Somme:disabled {
            background-color: #cccccc;
            color: #666666;
            cursor: not-allowed;
        }

        #Somme:disabled:hover {
            background-color: #cccccc;
        }

        #Somme:disabled:active {
            background-color: #cccccc;
            transform: translateY(0);
        }

        #Somme:disabled:focus {
            outline: none;
        }

        #Somme-container {
            display: flex;
            justify-content: center;
        }

        #Somme-container > * {
            margin: 0 5px;
        }

        #Somme-input {
            width: 100px;
            text-align: center;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }

        #SommeTitre{
            text-align: center;
            font-size: 20px;
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

        <?php

        echo "<b> Bienvenue $username ! </b> <br> <br>";
        $date = date('d/m/Y');
        echo "La date d'aujourd'hui est : " . $date . "<br>"; 
        echo "L'heure acutelle est : <span id='heure'></span> <br> <br>"

        ?>

        <div class="Vitrine">

            <?php
            
                function Nouvelle_Notif($ID_Profil,$Message)
                {
                    $comptesConn = new mysqli("localhost", "root", "", "comptes");

                    if ($comptesConn->connect_error) {
                        die("Échec de la connexion à la base de données 'comtpes': " . $comptesConn->connect_error);
                    }

                    $sql = "SELECT COUNT(*) AS total FROM notifications";
                    $result = $comptesConn->query($sql);

                    $data = mysqli_fetch_assoc($result);
                    $compteur = $data["total"] + 1;

                    $Message = mysqli_real_escape_string($comptesConn, $Message);

                    $sql = "INSERT INTO notifications(ID_Notif, ID_Profil, Messages, Temps) VALUES ('$compteur', '$ID_Profil', '$Message', NOW())";

                    if ($comptesConn->query($sql) === TRUE) {
                        echo "Nouvelle notification créée avec succès !";
                    } else {
                        echo "Erreur: " . $sql . "<br>" . $comptesConn->error;
                    }

                }

                function Secondes(){
                    $secondes = date('s');
        
                    return $secondes;
                }
        
                function Minutes(){
                    $minutes = date('i');
        
                    return $minutes;
                }
        
                function Heures(){
                    $heure = date('H');
        
                    return $heure;
                }

                $pseudo = $_SESSION['username'];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "articles";
        
                $conn = new mysqli($servername, $username, $password, $dbname);

                $conn_Comptes = new mysqli($servername, $username, $password, "comptes");
        
                // Vérifier la connexion à la base de données
                if ($conn->connect_error) {
                    die("Échec de la connexion à la base de données: " . $conn->connect_error);
                }

                if ($conn_Comptes->connect_error) {
                    die("Échec de la connexion à la base de données: " . $conn_Comptes->connect_error);
                }

                $HeureActuelle = Heures();

                $MinutesActuelle = Minutes();
                
                ///echo "<b> Heure actuelle : $HeureActuelle </b> <br> <br>";
                
                // Requête de sélection pour récupérer tous les éléments de la table
                $sql = "SELECT * FROM encheres";
                $result = $conn->query($sql);

                $ID_Article_Affiche=0;

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        // Récupérer les informations de l'article
                        $startHour = date('H', strtotime($row['Heure_Deb']));
                        $endHour = date('H', strtotime($row['Heure_Fin']));

                        $photo = "images/" . $row['Photo'];
                        $nomProduit = $row['NomProduit'];

                        // ...

                        /*if($MinutesActuelle < 30 && $HeureActuelle == $startHour && $row['ID_acheteur'] != NULL)
                        {
                            ///Reinitialiser le prix de l'article

                            $ID_Article_Affiche = $row['ID_Article'];

                            $sql = "UPDATE encheres SET Prix_Actuel = Prix_initial WHERE ID_Article = '$ID_Article_Affiche'";

                            if ($conn->query($sql) === TRUE) {
                                echo "prix updated successfully";
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }

                            $sql = "UPDATE encheres SET ID_acheteur = NULL WHERE ID_Article = '$ID_Article_Affiche'";

                            if ($conn->query($sql) === TRUE) {
                                echo "acheteur updated successfully";
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }

                        }*/

                        if($startHour == 20 && $HeureActuelle > 20)
                        {
                            $endHour = 24;
                        }

                        if($startHour == 20 && $HeureActuelle < 20)
                        {
                            $startHour = -4;
                        }

                        if ($HeureActuelle >= $startHour && $HeureActuelle < $endHour) {
                            // Utiliser la photo correspondante à l'heure actuelle
                            

                            $DernierAcheteur = $row['ID_acheteur'];

                            $utilisateurQuery = "SELECT Pseudo FROM profil WHERE ID_Profil = '$DernierAcheteur'";
                            $utilisateurResult = $comptesConn->query($utilisateurQuery);

                            if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
                                $utilisateurRow = $utilisateurResult->fetch_assoc();
                                $utilisateurPseudo = $utilisateurRow["Pseudo"];

                                ///echo "L'ID de l'utilisateur '$pseudo' est : $utilisateurID";
                            } else {
                                $utilisateurPseudo = "Aucune enchère pour le moment";
                            }
                                        
                            echo '<div class="encheresJour">';
                            echo '<div class="encheresJour-details">';
                            echo '<h3 class="enchereJour-title">' . $nomProduit . '</h3>';
                            echo '<p>Prix de départ : ' . $row['Prix_initial'] . ' €</p>';
                            echo '<p><b>Enchère actuel : ' . $row['Prix_Actuel'] . ' €</b></p>';
                            echo '<p>Dernier enchérisseur : ' . $utilisateurPseudo . '</p>';
                            echo '<p>Description : ' . utf8_encode($row['Description']) . '</p>';
                            echo '<div id="countdown' . $row['ID_article'] . '" class="countdown" data-end-time="' . strtotime($row['Heure_Fin']) . '"></div>';
                            ///ajout du bouton enchérir
                            echo '</div>';
                            echo '<div class="encheresJour-image">';
                            echo '<img src="' . $photo . '" alt="Article">';
                            echo '</div>';
                            echo '</div>';

                            $ID_Article_Affiche = $row['ID_article'];

                        } else {
                            // Utiliser une photo par défaut ou une autre logique selon vos besoins
                            
                        }
                    }
                    
                    if($HeureActuelle == $endHour - 1)
                    {
                        echo "Enchère terminée !";
                        echo "article remporté par $DernierAcheteur";
                        echo "L'article est maintenant dans votre panier !";
                        echo "félicitations !";


                        ///Mettre l'article dans le panier de l'acheteur ATTENDRE LE CODE DE LUCAS

                        /// IDEE

                        /*
                            // Requête pour récupérer tous les articles achetés par l'utilisateur connecté depuis la table "achatimmediat"
                            $articlesQuery = "SELECT * FROM encheres WHERE ID_acheteur = $utilisateurID";
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
                                echo "<tr><th>ID Article</th><th>Prix</th><th>Photo</th><th>Description</th>";
                                
                                while ($articleRow = $articlesResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$articleRow["ID_article"]."</td>";
                                    echo "<td>".$articleRow["Prix"]."€</td>";
                                    echo "<td><img src='".$articleRow["Photo"]."' alt='Photo' width='100' height='150'></td>";
                                    echo "<td>".$articleRow["Description"]."</td>";
                                    echo "<td><button onclick=\"supprimerPanier(" . $articleRow['ID_article'] . ")\">Supprimer</button></td>";

                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "Panier Vide";
                            }
                        */

                        $sql = "SELECT * FROM encheres WHERE ID_article = '$ID_Article_Affiche'";
                        $result = $conn->query($sql);

                        $NomProduit = "";

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()){
                                $ID_Article = $row['ID_article'];
                                $NomProduit = $row['NomProduit'];
                                $Prix = $row['Prix_Actuel'];
                                $Description = $row['Description'];
                                $Photo = $row['Photo'];
                                $ID_Vendeur = $row['ID_vendeur'];
                                $ID_Acheteur = $row['ID_acheteur'];
                                $Heure_Deb = $row['Heure_Deb'];
                                $Heure_Fin = $row['Heure_Fin'];
                                $Prix_initial = $row['Prix_initial'];

                                $sql = "INSERT INTO panier (ID_article, NomProduit, Prix, Description, Photo, ID_vendeur, ID_acheteur, Heure_Deb, Heure_Fin, Prix_initial) VALUES ('$ID_Article', '$NomProduit', '$Prix', '$Description', '$Photo', '$ID_Vendeur', '$ID_Acheteur', '$Heure_Deb', '$Heure_Fin', '$Prix_initial')";
                                $result = $conn->query($sql);

                                if ($result === TRUE) {
                                    echo "L'article a été ajouté au panier avec succès !";
                                } else {
                                    echo "Erreur: " . $sql . "<br>" . $conn->error;
                                }
                            }
                        }
                    }

                      
                } 
                else {
                    // Aucun article en enchères actuellement
                    // Afficher un message approprié ou effectuer une autre action
                }



                function displayCountdown($endTime) {

                    $conn_Comptes = new mysqli($servername, $username, $password, "comptes");
                    if ($conn_Comptes->connect_error) {
                        die("Échec de la connexion à la base de données: " . $conn_Comptes->connect_error);
                    }

                    $pseudo = $_SESSION["pseudo"];

                    $utilisateurQuery = "SELECT ID_profil FROM profil WHERE Pseudo = '$pseudo'";
                    $utilisateurResult = $comptesConn->query($utilisateurQuery);
                
                    if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
                        $utilisateurRow = $utilisateurResult->fetch_assoc();
                        $utilisateurID = $utilisateurRow["ID_profil"];
                
                        ///echo "L'ID de l'utilisateur '$pseudo' est : $utilisateurID";
                    }
                    else {
                        echo "Utilisateur non trouvé.";
                    }   

                    $currentTime = time();
                    $timeLeft = $endTime - $currentTime;

                    $ID_Acheteur = $utilisateurID;
                  
                    if ($timeLeft < 0) {
                      // L'enchère est terminée
                      echo "L'enchère est terminée.";
                      $Message = "Vous avez remporté l'enchère sur l'article" . $NomProduit . "pour la somme de " . $Somme . " €, Félécitations !";
                      Nouvelle_Notif($ID_Acheteur,$Message);

                    } else {
                      // Calcul des jours, heures, minutes et secondes restants
                      $days = floor($timeLeft / (60 * 60 * 24));
                      $hours = floor(($timeLeft % (60 * 60 * 24)) / (60 * 60));
                      $minutes = floor(($timeLeft % (60 * 60)) / 60);
                      $seconds = $timeLeft % 60;
                  
                      // Affichage du compte à rebours
                      return "Temps restant avant la fin de l'offre : " . $hours . "h " . $minutes . "m " . $seconds . "s";
                    }
                }

                $utilisateurQuery = "SELECT ID_profil FROM profil WHERE Pseudo = '$pseudo'";
                $utilisateurResult = $comptesConn->query($utilisateurQuery);
              
                if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
                      $utilisateurRow = $utilisateurResult->fetch_assoc();
                      $utilisateurID = $utilisateurRow["ID_profil"];
              
                      ///echo "L'ID de l'utilisateur '$pseudo' est : $utilisateurID";
                  }
                else {
                      echo "Utilisateur non trouvé.";
                }         
                

                if(isset($_POST['Action_Enchere']))
                {


                    $Somme = $_POST['Somme'];

                    $ID_Acheteur = $utilisateurID;
                    $Pseudo_Acheteur = $username;

                    $ID_Article = $ID_Article_Affiche;

                    ///echo $ID_Article;
                    
                    $sql = "SELECT * FROM encheres WHERE ID_article = '$ID_Article'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()){
                            $PrixActuel = $row['Prix_Actuel'];
                            $PrixInitial = $row['Prix_initial'];
                        }
                    }

                    $sql = "SELECT * FROM encheres WHERE ID_article = '$ID_Article'";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $utilisateurRow = $result->fetch_assoc();
                        $NomProduit = $utilisateurRow["NomProduit"];
                
                        ///echo "L'ID de l'utilisateur '$pseudo' est : $utilisateurID";
                    } else {
                        echo "Utilisateur non trouvé.";
                    }

                    if($Somme > $PrixActuel)
                    {

                        $sql = "UPDATE encheres SET ID_acheteur = '$ID_Acheteur', Prix_Actuel = '$Somme' WHERE ID_article = '$ID_Article'";
                        $result = $conn->query($sql);

                        
                        if ($result === true) {
                            // La requête de mise à jour s'est exécutée avec succès
                            //echo "Enchère enregistrée avec succès !";
                            $Message = "Vous avez enchéri sur l'article" . $NomProduit . "pour la somme de " . $Somme . " €";
                            Nouvelle_Notif($ID_Acheteur,$Message);
                        } else {
                            // Erreur lors de l'exécution de la requête de mise à jour
                            echo "Erreur lors de la mise à jour : " . $conn->error;
                        }

                    }
                    else
                    {
                        echo "Vous devez enchérir plus que l'enchère actuel pour pouvoir enchérir !";
                    }
                }


            ?>

            
        </div>

    </section>

    <section>
        <form action="affichageArticlesAchatEnchere.php" method="post">
            <label id="SommeTitre" for="Somme">Somme à enchérir:</label>
            <input type="number" id="Somme" name="Somme" required><br><br>

            <input type="submit" name="Action_Enchere" value="Enchérir">
        </form>
    </section>
  
    <footer>
       <a href="#">Conditions générales du site</a> | <a href="#">Politique de retours &amp; Remboursements</a>
    <p>
        <small> Droit d’auteur & Copyright © 2023, Agora Francia </small>
    </p>
    </footer>
</body>
</html>

<?php
    

?>