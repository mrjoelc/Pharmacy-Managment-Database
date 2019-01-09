<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Gestionale Posizione Farmacia</title>
		<!--External stylesheet links-->
		<link rel="stylesheet" href="../css/styles.css?<?php echo time(); ?>">
	

		<!--JQuery import e links-->
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

	</head>
	<body>
		
		<div class="container">
			<!-- Sezione LOGO-->
			<div class="headerCustom">
				<img class='logo' src="../img/logo.png">
				<h1 class="main-heading">Gestionale Posizione Farmacia</h1>
			</div>
		</div>

		<!-- Sezione NAVBAR -->
		<div id='navbarDiv'>
				<ul>
					<li class='active last-item-navbar'><a href="#">Gestione Aziende</a>
					<ul class="dropdown">
						<li class='firstSubItem'><a href="search-azienda.php">Cerca Azienda</a></li>
						<li><a href="add-azienda.php">Inserisci Azienda</a></li>
						<li class='lastSubItem'><a href="rmv-azienda.php">Elimina Azienda</a></li>
					</ul>  
					</li>
					<li><a href="#">Gestione Farmaci</a>
					<ul class="dropdown">
						<li class='firstSubItem'><a href="add-farmaco.php">Inserisci Farmaco</a></li>
						<li class='lastSubItem'><a href="rmv-farmaco.php">Elimina Farmaco</a></li>
					</ul>
					</li>
					<li class='first-item-navbar'><a href="index.php">Cerca</a></li>
				</ul>
			</div> 
		

		<!-- Sezione RICERCA -->
			<div class="row" style="background-color: #b4c0b4;">
				<p style='text-align: center;'class="description">Cerca e rimuovi una azienda nel sistema</p>
			</div>

	</body>

	<script src="../js/add-azienda.js"></script>

</html>
