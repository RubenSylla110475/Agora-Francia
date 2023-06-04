<?php
// Connexion à la base de données
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, "comptes");

if ($db_found) {
    $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : "";
    $nom = isset($_POST["nom"]) ? $_POST["nom"] : "";
    $pseudo = isset($_POST["pseudo"]) ? $_POST["pseudo"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $telephone = isset($_POST["numeroTelephone"]) ? $_POST["numeroTelephone"] : "";
    $mdp = isset($_POST["mdp"]) ? $_POST["mdp"] : "";
    $pp = isset($_POST["pp"]) ? $_POST["pp"] : "";
    $pc = isset($_POST["pc"]) ? $_POST["pc"] : "";
    $typeCompte = isset($_POST["typeCompte"]) ? $_POST["typeCompte"] : "";

    $pp = "images/" . $pp;
    $pc = "images/" . $pc;
    
    // Récupérer le nombre total de profils existants
    $sql = "SELECT COUNT(*) AS total FROM profil";
    $result = mysqli_query($db_handle, $sql);
    
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $compteur = $data["total"] + 1;

        // Ajouter un compte dans la base de données (table "profil")
        $sql = "INSERT INTO `profil`(`ID_profil`, `Type_compte`, `Nom`, `Prenom`, `Pseudo`, `Mail`, `PhotoProfil`, `PhotoCouverture`, `Adresse`, `NumeroCB`, `dateExpiration`, `Cryptogramme`, `TypeCarte`, `AdresseLigne1`, `AdresseLigne2`, `Ville`, `CodePostal`, `Pays`, `NumeroTelephone`, `MotDePasse`) 
        VALUES ($compteur,'$typeCompte','$nom','$prenom','$pseudo','$email','$pp','$pc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$telephone','$mdp')";
        $result = mysqli_query($db_handle, $sql);

        if ($result) {
            echo "Add successful.<br>";
            // Redirection vers la page d'accueil ou autre page souhaitée
            $username = $_POST['username']; // Supposons que le nom d'utilisateur soit envoyé via un formulaire POST
session_start();
            $_SESSION["username"] = $username;


            // Stocke l'information de connexion dans une variable de session
            $_SESSION["loggedIn"] = true;

            // Redirection vers la page d'accueil ou autre page souhaitée
            header("Location: login.html");
        } else {
            echo "Error: " . mysqli_error($db_handle) . "<br>";
        }
    } else {
        echo "Error: " . mysqli_error($db_handle) . "<br>";
    }
} else {
    echo "Database not found";
}

mysqli_close($db_handle);
?>
