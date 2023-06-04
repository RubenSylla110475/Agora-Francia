<?php
    
?>
<?php
    // Démarre la session
    session_start();
    // Ferme la session
    session_destroy();

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
		function connexion() {
			window.location.href = "login.html";
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
                    <a href="https://blog.hubspot.com/">Enchères</a>
                    <a href="https://academy.hubspot.com/">Négociations</a>
                    <a href="affichageArticlesAchatImmediat.php"> Achat immédiat </a>
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
	<h1>Vous n'êtes pas connecté !</h1>
</section>

<body>
	<button class="custom-button" onclick="connexion()">Se connecter</button>
</body>

<footer>
	<a href="#">Conditions générales du site</a> | <a href="#">Politique de retours &amp; Remboursements</a>
	<p>
		<small> Droit d’auteur &amp; © 2023, Agora Francia </small>
	</p>
</footer>

</html>
