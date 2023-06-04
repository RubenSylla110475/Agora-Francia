-<!-- ajouterVendeur.php -->




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
    $username = "root";
    $password = "";
    $dbname = "comptes";

    // Création de la connexion
    $comptesConn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($comptesConn->connect_error) {
        die("Erreur de connexion à la base de données : " . $comptesConn->connect_error);
    }

    // Vérification si le formulaire a été soumis
    if (isset($_POST["pseudo"]) && isset($_POST["password"]) && isset($_POST["nom"])) {
        // Récupération des valeurs du formulaire
        $pseudo = $_POST["pseudo"];
        $password = $_POST["password"];
        $nom = $_POST["nom"];
        $Mail = $_POST["Mail"];

        // Vérification si les champs requis sont remplis
        if (empty($pseudo) || empty($password) || empty($nom)) {
            echo "Veuillez remplir tous les champs du formulaire.";
        } else {
            // Vérification si le pseudo est déjà utilisé
            $checkQuery = "SELECT * FROM profil WHERE Pseudo = '$pseudo'";
            $checkResult = $comptesConn->query($checkQuery);

            if ($checkResult && $checkResult->num_rows > 0) {
                echo "Le pseudo est déjà utilisé. Veuillez choisir un autre pseudo.";
            } else {
                // Récupération de l'id du dernier profil
                $lastIdQuery = "SELECT MAX(id_profil) as max_id FROM profil";
                $lastIdResult = $comptesConn->query($lastIdQuery);
                $lastIdRow = $lastIdResult->fetch_assoc();
                $newId = $lastIdRow["max_id"] + 1;

                // Insertion du vendeur dans la table "profil"
                $insertQuery = "INSERT INTO profil (id_profil, Pseudo, MotDePasse, Nom, Type_compte, Mail) VALUES ('$newId', '$pseudo', '$password', '$nom', 2, '$Mail')";
                $insertResult = $comptesConn->query($insertQuery);

                if ($insertResult) {
                    echo "Le vendeur a été ajouté avec succès.";
                } else {
                    echo "Erreur lors de l'ajout du vendeur : " . $comptesConn->error;
                }
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
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required><br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="Mail">E-mail :</label>
        <input type="text" id="Mail" name="Mail" required><br><br>

        <input type="submit" value="Ajouter vendeur">
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
                        <td>9h - 18h</td>
                    </tr>
                    <tr>
                        <td>Dimanche</td>
                        <td>Fermé</td>
                    </tr>
                </table>
            <h4>Nous Contacter</h4>
                <p>Par téléphone : 01 23 45 67 89</p>
                <p>Par mail : AgoraFrancia@edu.ece.fr</p>
        </div>
        <div style="flex: 1;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41988.09853920827!2d2.224624156951904!3d48.87239311228893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66de0a67db16b%3A0x528689fff94f3c92!2sPublications%20Agora%20France!5e0!3m2!1sfr!2sfr!4v1685739640007!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    

</section>

<footer>
    <a href="#">Conditions générales du site</a> | <a href="#">Politique de retours &amp; Remboursements</a>
    <p>
        <small> Droit d’auteur &amp; Copyright © 2023, Agora Francia
        </small>
    </p>
</footer>
</body>
</html>