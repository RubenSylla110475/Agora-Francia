<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'ID de l'article et l'ID du compte ont été envoyés via le formulaire
    if (isset($_POST['id_article']) && isset($_SESSION['id_compte'])) {
        $articleID = $_POST['id_article'];
        $idCompte = $_SESSION['id_compte'];

        // Effectuer la mise à jour dans la base de données pour remplacer l'ID_acheteur par l'ID_compte
        // Assurez-vous d'ajuster les paramètres de connexion à la base de données selon votre configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "articles";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Échec de la connexion à la base de données: " . $conn->connect_error);
        }

        $sql = "UPDATE AchatImmediat SET ID_acheteur = $idCompte WHERE ID_article = $articleID";

        if ($conn->query($sql) === TRUE) {
            echo "done";
        } else {
            echo "Erreur lors de la mise à jour de la base de données: " . $conn->error;
        }

        $conn->close();
    }
}
?>
