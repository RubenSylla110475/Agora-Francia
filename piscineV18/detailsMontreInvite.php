<!DOCTYPE html>
<html>
<head>
    <title>Affichage des éléments</title>
    <link rel="stylesheet" href="Style_Accueil.css">
    <style>

      .buy-button {
        background-color: #B2935B;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .buy-button:hover {
        background-color: #824d2c;
    }
    </style>
</head>
<body>
    <header>
    <div id="header-container">
      <div id="logo">
        <img src="images/logo.png" alt="Logo Agora Francia" height="300 px">
      </div>

      <script>
          function done() {
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
    <h2>Veuillez vous enregistrer si vous souhaitez voir cet article plus en détails.</h2>
    </div>
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
