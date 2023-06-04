<?php
// Connexion à la base de données
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, "comptes");

$username = isset($_POST["username"]) ? $_POST["username"] : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";

if ($db_found) {
    $sql = "SELECT * FROM profil";
    $result = mysqli_query($db_handle, $sql);

    while ($data = mysqli_fetch_assoc($result)) {
        if ($username == $data["Pseudo"] && $password == $data["MotDePasse"]) {
            echo "Authentification réussie !";

            // Démarre la session
            session_start();
            $_SESSION["username"] = $username;


            // Stocke l'information de connexion dans une variable de session
            $_SESSION["loggedIn"] = true;

            // Redirection vers la page d'accueil ou autre page souhaitée
            header("Location: compte.php");
            exit;
        } else {
            echo "Erreur de connexion";
        }
    }
} else {
    echo "Database not found";
}
mysqli_close($db_handle);
?>
