<?php
// Démarre la session
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
    $utilisateurQuery = "SELECT Nom FROM profil WHERE Pseudo = '$pseudo'";
    $utilisateurResult = $comptesConn->query($utilisateurQuery);

    if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
        $utilisateurRow = $utilisateurResult->fetch_assoc();
        $utilisateurNom = $utilisateurRow["Nom"];


        ///echo "L'ID de l'utilisateur '$username' est : $utilisateurID";
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



$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, "articles");

if (!$db_found) {
    echo "<p>Database not found</p>";
    exit;
}

if (isset($_POST["bouton1"])) {
    
    $Prix = isset($_POST["Prix"]) ? $_POST["Prix"] : "";
    $Photo = isset($_FILES["Photo"]["name"]) ? $_FILES["Photo"]["name"] : "";
    $typeArticle = isset($_POST["typeArticle"]) ? $_POST["typeArticle"] : ""; // Pas de valeur par défaut définie

    $Description = isset($_POST["Description"]) ? $_POST["Description"] : "";
    $Video = isset($_POST["Video"]) ? $_POST["Video"] : "";

    $Photo = "images/" . $Photo;
    // Requête pour vérifier si l'article existe déjà
    $sql = "SELECT * FROM achatimmediat";
    //avec son titre et auteur
    if ($Description != "") {
        $sql .= " WHERE Description LIKE '%$Description%'";
        if ($Photo != "") {
            $sql .= " AND Photo LIKE '%$Photo%'";
        }
    }

    $result = mysqli_query($db_handle, $sql);

    if (mysqli_num_rows($result) != 0) {
        echo "<p>Artcile déjà existant</p>";
    }
    else
    {
        $sql = "SELECT COUNT(*) AS total FROM achatimmediat";
        $result = mysqli_query($db_handle, $sql);

        $data = mysqli_fetch_assoc($result);
        $compteur = $data["total"] + 1;

        $ID_Vendeur = (int)$utilisateurID;

        ///ajout du livre dans la BDD
        $sql = "INSERT INTO achatimmediat(ID_article, ID_vendeur, Notifications, Prix, NouveauPrix, ID_acheteur, Nom, Photo, typeArticle, Description, Video) 
        VALUES ('$compteur', '$ID_Vendeur', 'disponible', '$Prix', '$Prix', 0, '$utilisateurNom', '$Photo', '$typeArticle', '$Description', '$Video')";

        $result =mysqli_query($db_handle, $sql);

        if($result)
        {
            echo "<p>Article ajouté</p>";
            echo "<p>ID article : $compteur | Description Article : $Description</p>";
            header("Location: Accueil.php");
        }
        else
        {
            echo "<p>Erreur lors de l'ajout de l'article " . mysqli_error($db_handle). "</p>";
        }



    }
}
$comptesConn->close();

mysqli_close($db_handle);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Style_Accueil.css">
    <title>Formulaire Achat Immédiat</title>
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
        input[type="submit"],
        input[type="file"] {
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

        #dropzone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
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

    <h2 style="text-align: center;">Mise en vente d'une montre de type achat imm&eacute;diat</h2>
    <form action="AjouterUnArticle.php" method="post" enctype="multipart/form-data">

        <label for="Description">Description:</label>
        <input type="text" id="Description" name="Description" required><br><br>


        <label for="Prix">Prix (euros):</label>
        <input type="text" id="Prix" name="Prix" required><br><br>

        <label for="pp">Photo de l'article : </label>
		<input type="file" id="Photo" name="Photo" accept="images/png, images/jpeg, images/jpg, images/JPG"><br><br>

        <label for="typeArticle">Type d'article:</label>
        <select id="typeArticle" name="typeArticle" required>
            <option value="1">R&eacute;gulier</option>
            <option value="2">Haut de gamme</option>
            <option value="3">rare</option>
        </select><br><br>


        <label for="Video">Vid&eacute;o:</label>
        <input type="text" id="Video" name="Video" required><br><br>

        <input type="submit" name="bouton1" value="Soumettre">
    </form>

    <script>
        function handleDragOver(event) {
            event.preventDefault();
        }

        function handleDrop(event) {
            event.preventDefault();

            var files = event.dataTransfer.files;
            var file = files[0];

            // Mettez à jour l'élément de formulaire avec le fichier sélectionné
            document.getElementById('Photo').files = files;

            if (file.type.match('image.*')) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 200;

                    var dropzone = document.getElementById('dropzone');
                    dropzone.innerHTML = '';
                    dropzone.appendChild(img);
                };

                reader.readAsDataURL(file);
            } else {
                alert("Veuillez sélectionner une image.");
            }
        }
    </script>
</body>

</html>
