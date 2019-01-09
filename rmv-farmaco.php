<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Gestionale Posizione Farmacia</title>
		<!--External stylesheet links-->
		<link rel="stylesheet" href="../css/styles.css?<?php echo time(); ?>">
		<link rel="stylesheet" href="../css/index.css?<?php echo time(); ?>">
		<link rel="stylesheet" href="../css/rmv-farmaco.css?<?php echo time(); ?>">

		<?php
			if (isset($_POST['submit'])) {
				if (isset($_POST['searchWord'])) {
					try {
						//Connessione al DB & setup debugging mode
						$pdo = new PDO("mysql:host=localhost; dbname=Farmacia", "root", "root");
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								
						//Crea variabili per maggiore facilità d'uso
						$searchWord = $_POST['searchWord'];
						$category = $_POST['category'];
								
						//Preparazione query corretta
						//CASI:
						//1 searchword presente (!=''), category non presente (=='') 
						//2 searchword presente (!=''), category presente (!='') 
						//caso 1
						if ($searchWord != '' && $category == ''){
							$prep_stmt=$pdo->prepare("SELECT * FROM Farmaco WHERE nomeFarmaco LIKE :searchWord");
						}
						//caso2
						if ($searchWord != '' && $category != ''){								
							$prep_stmt=$pdo->prepare("SELECT * FROM PosizioneFarmaco JOIN Scaffale USING (n_scaf) 
													  WHERE PosizioneFarmaco.nomeFarmaco LIKE :searchWord 
													  AND Scaffale.categoria = :category");
									
							$prep_stmt->bindValue(':category', "{$_POST['category']}");
						}
						$prep_stmt->bindValue(':searchWord', "%{$_POST['searchWord']}%");
						$prep_stmt->execute();
						$farmaci=$prep_stmt->fetchAll();
								
						if ($farmaci) {
							$noOfResults = (String) count($farmaci);
						}
					}catch (PDOException $e) {
						echo 'Connection error: '.$e->getMessage();
						exit();
					}
					//chiudi la connessione con il DB
					$pdo = null; 
				}
			}
		?>

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
					<li class='last-item-navbar'><a href="#">Gestione Aziende</a>
					<ul class="dropdown">
						<li class='firstSubItem'><a href="search-azienda.php">Cerca Azienda</a></li>
						<li><a href="add-azienda.php">Inserisci Azienda</a></li>
						<li class='lastSubItem'><a href="rmv-azienda.php">Elimina Azienda</a></li>
					</ul>  
					</li>
					<li class='active'><a href="#">Gestione Farmaci</a>
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
				<p style='text-align: center;'class="description">Cerca e rimuovi un farmaco nel sistema</p>
			</div>

			<div class="row center" style="background-color: #b4c0b4;">
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
					<input required type="text" class=" search-bar-index " name="searchWord" id="searchBox" placeholder="Inserisci nome Farmaco o Azienda "/>
					<br />
					<br />
					
					<div style='display:flex; flex-direction: row;'> 
						<div class="select-style" style='width: 450px;'>
							<select name='category'>
								<option value="">Tutte le categorie</option>
								<option value="Sistema Cardiovascolare">Sistema Cardiovascolare</option>
								<option value="Sistema Gastrointestinale e Metabolismo">Sistema Gastrointestinale e Metabolismo</option>
								<option value="Sangue e Organi Emopoietici">Sangue e Organi Emopoietici</option>
								<option value="Antineoplastici e Immunomodulatori">Antineoplastici e Immunomodulatori</option>
								<option value="Sistema Nervoso Centrale">Sistema Nervoso Centrale</option>
								<option value="Apparato Respiratorio">Apparato Respiratorio</option>
							</select>
						</div>

						<input type="submit" class="search-button-rmv" value="Cerca" name="submit"/>
					</div>
				</form>
				<br />
			</div>

			<div class="container" style="margin-top:-50px; background-color: #b4c0b4;">
			<div class="row center" style="background-color: #b4c0b4;">
				<?php
					if (isset($noOfResults)) {
						echo "<h1 class='main-results'>{$noOfResults} ";
						if ($noOfResults>1) {echo "risultati ";} else {echo "risultato ";}
						if ($searchWord != '') {echo "per '$searchWord'</h1> <br /> <br />";} else {echo "nella categoria '$category'</h1> <br /> <br />";}
					}
				?>
			</div>
			<div class="row" style="background-color: #b4c0b4;">
				<?php
					if (isset($farmaci)) {
						if ($farmaci) {
							foreach ($farmaci as $farmaco) {
								echo "<a class='link-farm center' href='rmv-farmaco-details.php?nameF=$farmaco[nomeFarmaco]'>{$farmaco['nomeFarmaco']}, {$farmaco['nomeAzienda']}</a>";
							}	
						} else {
							echo "<br /><h1 class='center'>Nessun risultato con la seguente";
							if ($searchWord != '') {echo " ricerca '$searchWord'</h1>";} else {echo " categoria '$category'</h1> <br /> <br />";}
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
