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
$utilisateurID = 0;

// Récupération des informations de l'utilisateur connecté depuis la table "profil"
$utilisateurQuery = "SELECT ID_profil FROM profil WHERE Pseudo = '$pseudo'";
$utilisateurResult = $comptesConn->query($utilisateurQuery);

if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
    $utilisateurRow = $utilisateurResult->fetch_assoc();
    $utilisateurID = $utilisateurRow["ID_profil"];
} else {
    echo "Utilisateur non trouvé.";
}

// Récupération du statut de l'utilisateur connecté depuis la table "profil"
$utilisateurStatut = 0;

$utilisateurQuery = "SELECT Type_compte FROM profil WHERE Pseudo = '$pseudo'";
$utilisateurResult = $comptesConn->query($utilisateurQuery);

if ($utilisateurResult && $utilisateurResult->num_rows > 0) {
    $utilisateurRow = $utilisateurResult->fetch_assoc();
    $utilisateurStatut = $utilisateurRow["Type_compte"];
} else {
    echo "Utilisateur non trouvé.";
}

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
        echo "<tr><th>ID Article</th><th>ID Vendeur</th><th>Nom du Vendeur</th><th>Statut</th><th>Prix</th><th>Photo</th><th>Description</th><th>Action</th>";

        $total = 0;
        $articlesAffiches = array(); // Tableau pour stocker les articles déjà affichés

        while ($articleRow = $articlesResult->fetch_assoc()) {
            // Vérifier si l'article a déjà été affiché
            if (in_array($articleRow['ID_article'], $articlesAffiches)) {
                continue; // Ignorer l'article déjà affiché
            }

            echo "<tr>";
            echo "<td>".$articleRow["ID_article"]."</td>";
            echo "<td>".$articleRow["ID_vendeur"]."</td>";
            echo "<td>".$articleRow["Nom"]."</td>";
            echo "<td>".$articleRow["Notifications"]."</td>";
            echo "<td>".$articleRow["Prix"]."€</td>";
            echo "<td><img src='".$articleRow["Photo"]."' alt='Photo' width='100' height='150'></td>";
            echo "<td>".$articleRow["Description"]."</td>";
            echo "<td><button onclick=\"supprimerPanier(" . $articleRow['ID_article'] . ")\"><img src='images/poubelle.jpg' alt='Supprimer' width='20' height='20'></button></td>";

            echo "</tr>";

            $articlesAffiches[] = $articleRow['ID_article']; // Ajouter l'article au tableau des articles affichés

            $total += $articleRow["Prix"];
        }

        echo "<tr><td colspan='4'><strong>Total:</strong></td><td>".$total."€</td><td colspan='3'></td></tr>";

        echo "</table>";
        return false; // Le panier n'est pas vide
    } else {
        echo "Panier Vide";
        return true; // Le panier est vide
    }
}

function supprimer_tout_panier($utilisateurID) {
    $articlesConn = new mysqli("localhost", "root", "", "articles");

    if ($articlesConn->connect_error) {
        die("Échec de la connexion à la base de données 'articles': " . $articlesConn->connect_error);
    }

    // Requête pour supprimer tous les articles du panier de l'utilisateur
    $supprimerPanierQuery = "UPDATE achatimmediat SET ID_acheteur = NULL WHERE ID_acheteur = $utilisateurID";

    if ($articlesConn->query($supprimerPanierQuery) === TRUE) {
        echo "Le panier a été vidé avec succès.";
    } else {
        echo "Erreur lors de la suppression du panier: " . $articlesConn->error;
    }

    $articlesConn->close();
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $adresseLigne1 = $_POST["adresse_ligne1"];
    $adresseLigne2 = $_POST["adresse_ligne2"];
    $ville = $_POST["ville"];
    $codePostal = $_POST["code_postal"];
    $pays = $_POST["pays"];
    $numeroCarte = $_POST["numero_carte"];
    $cryptogramme = $_POST["cryptogramme"];
    $dateExpiration = $_POST["date_expiration"];
    $nomTitulaire = $_POST["nom_titulaire"];

    // Connexion à la base de données "comptes"
    $comptesConn = new mysqli("localhost", "root", "", "comptes");

    if ($comptesConn->connect_error) {
        die("Échec de la connexion à la base de données 'comptes': " . $comptesConn->connect_error);
    }

    // Mise à jour des informations de profil dans la table "profil"
    $updateQuery = "UPDATE profil SET AdresseLigne1='$adresseLigne1', AdresseLigne2='$adresseLigne2', Ville='$ville', CodePostal='$codePostal', Pays='$pays', NumeroCB='$numeroCarte', Cryptogramme='$cryptogramme', dateExpiration='$dateExpiration', Nom='$nomTitulaire' WHERE ID_profil='$utilisateurID'";

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

    if ($comptesConn->query($updateQuery) === TRUE) {
        echo "Les informations de paiement et de livraison ont été enregistrées avec succès.";

        Nouvelle_Notif($utilisateurID, "Votre paiement a été effectué avec succès.");
        Nouvelle_Notif($utilisateurID, "Votre colis est en cours de livraison. Vous recevrez un mail de confirmation dès que votre colis sera arrivé.");
        header("Location: accueil.php");
        // Supprimer tous les articles du panier de l'utilisateur
        supprimer_tout_panier($utilisateurID);

        // Rediriger vers la page d'accueil
        
    } else {
        echo "Erreur lors de l'enregistrement des informations de paiement et de livraison: " . $comptesConn->error;
    }

    $comptesConn->close();
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
            if (confirm("Êtes-vous sûr de vouloir supprimer cet article du panier ?")) {
              window.location.href = "supprimerPanier.php?articleID=" + articleID;
            }
          }
        
        </script>
        
      </script>


      <nav style="display: flex; justify-content: center;">
        <ul>
          <li class="white" type="button"><a href="Accueil.php"><b>Accueil</b></a></li>
          <div class="dropdown" type="button">
            <b>Parcourir</b>
            <div class="dropdown-content">
              <a href="affichageArticlesAchatEnchere.php">Enchères</a>
              <a href="affichageArticlesAchatNegociation.php">Négociations</a>
              <a href="affichageArticlesAchatImmediat.php">Achat immédiat</a>
              <?php
                if ($utilisateurStatut == 3 || $utilisateurStatut == 2) {
                  echo '<a href="AjouterUnArticle.php">Mettre en Vente</a>';
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
          <li class="white" type="button"><a href="panier.php"><b>Panier</b></a></li>
          <li class="white" type="button"><a href="compte.php"><b>Compte</b></a></li>
        </ul>
      </nav>
    </div>
  </header>
  
  <section>
    <h2>Votre Panier</h2>
    <div id="Panier">
      <?php
      if (!Affichage_Panier($utilisateurID)) {
      ?>
     <form action="achat.php" method="post">
      

      <h3>Informations de livraison</h3>
      <label for="adresse_ligne1">Adresse ligne 1:</label>
      <input type="text" id="adresse_ligne1" name="adresse_ligne1" required><br>

      <label for="adresse_ligne2">Adresse ligne 2:</label>
      <input type="text" id="adresse_ligne2" name="adresse_ligne2"><br>

      <label for="ville">Ville:</label>
      <input type="text" id="ville" name="ville" required><br>

      <label for="code_postal">Code postal:</label>
      <input type="text" id="code_postal" name="code_postal" required><br>

      <label for="pays">Pays:</label>
      <input type="text" id="pays" name="pays" required><br>

      <h3>Informations bancaires</h3>
      <label for="numero_carte">Numéro de carte:</label>
      <input type="text" id="numero_carte" name="numero_carte" required><br>

      <label for="cryptogramme">Cryptogramme:</label>
      <input type="text" id="cryptogramme" name="cryptogramme" required><br>

      <label for="date_expiration">Date d'expiration:</label>
      <input type="text" id="date_expiration" name="date_expiration" required pattern="\d{2}/\d{2}" placeholder="MM/AA"><br>

      <label for="nom_titulaire">Nom du titulaire de la carte:</label>
      <input type="text" id="nom_titulaire" name="nom_titulaire" required><br>

      <input type="submit" value="Valider le paiement">
    </form>
      <?php
      }
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