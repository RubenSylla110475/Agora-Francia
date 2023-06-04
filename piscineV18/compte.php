<?php

	// Démarre la session
	session_start();

	// Vérification si l'utilisateur est connecté
	if (!isset($_SESSION['username'])) {
		// Redirection vers la page de connexion
		header("Location: logout.php");
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
    $utilisateurQuery = "SELECT Type_compte, Nom FROM profil WHERE Pseudo = '$username'";
    $utilisateurResult = $comptesConn->query($utilisateurQuery);

    if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
        $utilisateurRow = $utilisateurResult->fetch_assoc();
        $utilisateurStatut = $utilisateurRow["Type_compte"];
        $utilisateurNom = $utilisateurRow["Nom"];

        ///echo "L'ID de l'utilisateur '$username' est : $utilisateurID";
    } else {
        echo "Utilisateur non trouvé.";
    }

    $utilisateurQuery = "SELECT ID_profil FROM profil WHERE Pseudo = '$username'";
    $utilisateurResult = $comptesConn->query($utilisateurQuery);

    if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
        $utilisateurRow = $utilisateurResult->fetch_assoc();
        $utilisateurID = $utilisateurRow["ID_profil"];

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

	<title>Comptes | Agora Francia</title>
	<link rel="icon" type="image/png" size="32x32" href="Icone.png">

	<script>
		function deconnexion() {
       window.location.href = "logout.php";
    }
    function promotion() {
       window.location.href = "promotion.php";
    }

		function toggleNumeroCB() {
			var numeroCBElement = document.getElementById('numeroCB');
			var numeroCB = numeroCBElement.innerHTML;
			var numeroCBCache = numeroCBElement.getAttribute('data-cache');

			if (numeroCBElement.innerHTML === numeroCBCache) {
				numeroCBElement.innerHTML = numeroCB;
			} else {
				numeroCBElement.innerHTML = numeroCBCache;
			}
		}
	</script>
</head>

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

<?php 
// Connecter l'utilisateur à la base de données
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, "comptes");

if ($db_found) {
	$sql = "SELECT * FROM profil";
	$result = mysqli_query($db_handle, $sql);

	$username = isset($_SESSION["username"]) ? $_SESSION["username"] : ""; // Utilisation de la session pour récupérer le nom d'utilisateur

	while ($data = mysqli_fetch_assoc($result)) {
		if ($username == $data['Pseudo']) { // Vérifier si le nom d'utilisateur correspond
			$photoProfil = $data['PhotoProfil'];
			$pseudo = $data['Pseudo'];
			$nom = $data['Nom'];
			$prenom = $data['Prenom'];
			$mail = $data['Mail'];
			$adresse = $data['Adresse'];
			$photoCouverture = $data['PhotoCouverture'];
			$numeroCB = $data['NumeroCB'];
			$cryptogramme = $data['Cryptogramme'];
			$typeCarte = $data['TypeCarte'];
			$numeroCBCache = "**** **** **** " . substr($numeroCB, -4);
			$numeroTelephonne = $data['NumeroTelephone'];
			$Num_Statut = $data['Type_compte'];
			
			if($Num_Statut == 1)
			{
				$Statut_Compte = "Acheteur";
			}
			elseif($Num_Statut == 2)
			{
				$Statut_Compte = "Vendeur";
			}
			elseif($Num_Statut == 3)
			{
				$Statut_Compte = "Administrateur";
			}

			break; // Sortir de la boucle une fois que les données sont trouvées
		}
	}
}
else {
	echo "Database not found";
	// Fermer la connexion
	mysqli_close($db_handle);
	exit;
}
// Fermer la connexion
mysqli_close($db_handle);
?>

<section>
	<div id="Couverture">
		<img src="<?php echo isset($photoCouverture) ? $photoCouverture : ''; ?>" alt="image de fond" width="400px">
	</div>
</section>

<body>
	<div class="Profil">
		<img src="<?php echo isset($photoProfil) ? $photoProfil : ''; ?>" alt="photo de profil">
		<h2>Bienvenue <?php echo isset($pseudo) ? $pseudo : ''; ?> !</h2>
	</div>

	<div class="Informations">
		<p><span>Informations personnelles:</span></p><br>
		<p><b>Nom: </b><?php echo isset($nom) ? $nom : ''; ?></p>
		<p><b>Prénom: </b><?php echo isset($prenom) ? $prenom : ''; ?></p>
		<p><b>Mail: </b><?php echo isset($mail) ? $mail : ''; ?></p>
		<p><b>Adresse: </b><?php echo isset($adresse) ? $adresse : ''; ?></p>
			<p><b>Numéro de CB: </b><span id="numeroCB" data-cache="<?php echo isset($numeroCBCache) ? $numeroCBCache : ''; ?>" onclick="toggleNumeroCB()"><?php echo isset($numeroCBCache) ? $numeroCBCache : ''; ?></span></p>
			<p><b>Code de sécurité: </b><?php echo isset($cryptogramme) ? $cryptogramme : ''; ?></p>
			<p><b>Type de carte: </b><?php echo isset($typeCarte) ? $typeCarte : ''; ?></p>
			<p><b>Numéro de téléphone: </b><?php echo isset($numeroTelephonne) ? $numeroTelephonne : ''; ?></p>
			<p><b>Statut du compte: </b><?php echo isset($Statut_Compte) ? $Statut_Compte : ''; ?></p>
	</div>

	<section>
	<table cellpadding="15px">
		<tr>
			<h2> Mes articles à vendre :</h2>
			<td width="50%">
			    <?php
    // Connexion à la base de données (vous devez ajuster les paramètres selon votre configuration)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "articles";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $username = $_SESSION['username'];

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données: " . $conn->connect_error);
    }

    // Requête de sélection pour récupérer les articles du vendeur actuel
    $sql = "SELECT a.*, c.*
            FROM articles.achatImmediat a, comptes.profil c 
            WHERE a.ID_vendeur = c.ID_profil AND '$utilisateurNom' = a.Nom AND '$username' = '$pseudo'";

    $result = $conn->query($sql);

    // Vérifier si la requête s'est exécutée correctement
    if ($result !== false) {
        // Vérifier s'il y a des résultats
        if ($result->num_rows > 0) {
            // Afficher les éléments
            while ($row = $result->fetch_assoc()) {
                $prix = $row['Prix'];
                $description = $row['Description'];
                $photo = $row['Photo'];
                $Nom = $row['Nom'];
                $ID_vendeur=$row['ID_vendeur'];
                $nouveauPrix=$row['NouveauPrix'];
                $Video = $row['Video'];

                // Afficher les données de chaque élément
                echo "<div class='item'>";
                echo "<h3>Description :</h3>";
                echo "<p>$description</p>";
                echo "<a href='detailsMontre.php?id=" . $row['ID_article'] . "'><div class='item-photo'><img src='$photo' alt='Photo de l'article' height='200px'></div></a>";
                echo "<div class='item-details'>";
                echo "<h3>Prix :</h3>";
                echo "<p>$nouveauPrix €</p><br>";

                echo "<b><u>Appliquer une promotion</u></b><br>";

                echo "<form method='POST' action=''>";
                echo "<br><b>Nouveau prix :</b><br><input type='text' name='nouveau_prix'><br>";
                echo "<input type='submit' name='submit' value='Mettre à jour'>";
                echo "</form>";

                if (isset($_POST['submit'])) {
                    // Récupérer le nouveau prix du formulaire
                    $nouveauPrix = isset($_POST["nouveau_prix"]) ? $_POST["nouveau_prix"] : "";

                    // Vérifier si le prix est valide
                    if (is_numeric($nouveauPrix)) {
                        $prixActuel = $row['Prix'];
                        $ID_article = $row['ID_article'];
                    
                        if ($nouveauPrix < $prixActuel) {

                            // Vérifier si l'ID_article existe déjà dans la table "achatReduit"
                            $checkSql = "SELECT ID_article FROM achatreduit WHERE ID_article = $ID_article";
                            $checkResult = $conn->query($checkSql);
                    
                            if ($checkResult !== false && $checkResult->num_rows > 0) {
                                echo "l'article existe déjà dans la table 'achatReduit'";
                            }
                            else{
                                // Insérer les données dans la table "achatReduit"
                                $insertSql = "INSERT INTO achatreduit (`ID_article`, `ID_vendeur`, `Prix`, `PrixReduit`, `ID_acheteur`, `Photo`, `typeArticle`, `Description`, `Video`) 
                                VALUES ($ID_article, $ID_vendeur, $prix, $nouveauPrix, NULL, '$photo', 0, '$description', '$Video')";
                                
                                if ($conn->query($insertSql) === true) {
                                    echo "Le prix a été ajouté avec succès dans la table 'achatReduit'.";
                                } else {
                                    echo "Erreur lors de l'ajout du prix dans la table 'achatReduit': " . $conn->error;
                                }
                            }

                            $updateSql = "UPDATE achatImmediat SET NouveauPrix = $nouveauPrix WHERE ID_article = $ID_article";
                                if ($conn->query($updateSql) === true) {
                                    //echo "Le prix a été mis à jour avec succès dans la table 'achatImmediat'.";
                                } else {
                                    // echo "Erreur lors de la mise à jour du prix dans la table 'achatImmediat': " . $conn->error;
                                }

                                // Mettre à jour le champ "nouveauPrix" dans la table "achatImmediat"
                                $updateSql = "UPDATE achatreduit SET PrixReduit = $nouveauPrix WHERE ID_article = $ID_article";
                                if ($conn->query($updateSql) === true) {
                                    //echo "Le prix a été mis à jour avec succès dans la table 'achatReduit'.";
                                } else {
                                    // echo "Erreur lors de la mise à jour du prix dans la table 'achatReduit': " . $conn->error;
                                }   

                                

                            } 
                        }
                    } else {
                        // echo "Le prix saisi n'est pas valide. Vérifié que celui-ci est bien inférieur au prix actuel.";
                    }
                    
                }

                echo "</div>";
                echo "</div>";
            }

    } else {
        // echo "Erreur lors de l'exécution de la requête : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
?>

			</td>
		</tr>

	</table>
    
</section>

	<button class="custom-button" onclick="deconnexion()">Déconnexion</button>
</body>

<footer>
	<a href="#">Conditions générales du site</a> | <a href="#">Politique de retours &amp; Remboursements</a>
	<p>
		<small> Droit d’auteur &amp; © 2023, Agora Francia </small>
	</p>
</footer>

</html>
