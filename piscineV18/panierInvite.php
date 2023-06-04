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
          function connexion() {
            window.location.href = "login.html";
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
    <h1>Vous n'êtes pas connecté ! </h1><br><br>
    <h2>Veuillez vous enregistrer si vous souhaitez ajouter des articles dans votre panier.</h2>
  </section>

  <body>
    <button class="custom-button" onclick="connexion()">Se connecter</button>
  </body>
  
  <footer>
    <a href="#">Conditions générales du site</a> | <a href="#">Politique de retours &amp; Remboursements</a>
    <p>
        <small> Droit d’auteur & Copyright © 2023, Agora Francia </small>
    </p>
  </footer>
</body>
</html>