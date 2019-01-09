<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Gestionale Posizione Farmacia</title>
		<!--External stylesheet links-->
		<link rel="stylesheet" href="../css/index.css?<?php echo time(); ?>">
		<link rel="stylesheet" href="../css/styles.css?<?php echo time(); ?>">

		<?php
			if (isset($_POST['searchWord'])) {
					try {
						//Connessione al DB & setup debugging mode
						$pdo = new PDO("mysql:host=localhost; dbname=Farmacia", "root", "root");
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						$prep_stmt=$pdo->prepare("SELECT * FROM Azienda
												  WHERE nomeAzienda LIKE :searchWord");
						
						$prep_stmt->bindValue(':searchWord', "%{$_POST['searchWord']}%");

						$prep_stmt->execute();
                        $aziende=$prep_stmt->fetchAll();
                        
                        if ($aziende) {
                            $noOfResults = (String) count($aziende);
                        }

					}catch (PDOException $e) {
						echo 'Connection error: '.$e->getMessage();
						exit();
					}
					$pdo = null; 
		
				}
		?>
	</head>
	<body>
		
		<div class="container">
			<!-- Sezione Header e Navbar -->
			<div class="headerCustom">
				<img class='logo' src="../img/logo.png">
				<h1 class="main-heading">Gestionale Posizione Farmacia</h1>
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

			<!-- Sezione Ricerca -->
			<div class="row center" style="background-color: #b4c0b4;">
				<p class="description">Cerca l'azienda farmaceutica per eliminarla.</p>
			</div>

			<div class="row center" style="background-color: #b4c0b4;">
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
					<input required type="text" class=" search-bar-index " name="searchWord" id="searchBox" placeholder="Inserisci nome Azienda "/>
					<br />
					<br />
					<div style='display:flex; justify-content:center; overflow:hidden;'><input type="submit" class="btn search-button-mini" value="Cerca" name="submit"/></div>
					
				</form>
				<br />
			</div>
		</div>
		
		<!-- Sezione Risultati -->
		<div class="container" style="padding-top:0px; background-color: #b4c0b4;">
			<div class="center" style="background-color: #b4c0b4;">
				<?php
					if (isset($noOfResults)) {
						echo "<h1 class='main-results'>{$noOfResults} ";
						if ($noOfResults>1) {echo "risultati ";} else {echo "risultato ";}
					    echo "per '$_POST[searchWord]'</h1> <br /> <br />";
					}
				?>
			</div>
			<div class="row" style="background-color: #b4c0b4;">
				<?php
					if (isset($aziende)) {
						if ($aziende) {
							foreach ($aziende as $azienda) {
								echo "<a class='link-farm center' href='rmv-azienda-details.php?nameA=$azienda[nomeAzienda]'>{$azienda['nomeAzienda']}</a>";
							}	
						} else {
							echo "<br /><h1 class='center'>Nessun risultato con la seguente ricerca '$searchWord'</h1>";
						}
					} else {
						echo "<br />
							<h1 class='noFill center'>Riempi il campo di ricerca</h1>";
					}
				?>
				<br />
			</div>
			<div style="width:100%; height:150px"></div>
		</div>

	</body>

</html>
