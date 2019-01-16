<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Gestionale Posizione Farmacia</title>
		<!--External stylesheet links-->
		<link rel="stylesheet" href="../css/index.css?<?php echo time(); ?>">
		<link rel="stylesheet" href="../css/styles.css?<?php echo time(); ?>">

		<!--JQuery import e links-->
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>


		<?php
					if (isset($_POST['submit'])) {
						if (isset($_POST['searchWord'])) {
							try {
								//Connessione al DB & setup debugging mode
								$pdo = new PDO("mysql:host=localhost; dbname=Farmacia", "root", "root");
								$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								
								//Crea variabili per maggiore facilità d'uso
								$searchWord = $_POST['searchWord'];
								$option = $_POST['searchOption'];
								$category = $_POST['category'];
								// echo "'$searchWord', '$option', '$category'";  DEBUG
								
								//Preparazione query corretta
								//CASI:
								//1 searchword presente (!=''), category non presente (=='') 
								//2 searchword non presente (==''), category presente (!='') 
								//3 searchword presente (!=''), category presente (!='') 
								//4 nessun delle due presenti 
								
								//caso 1
								if ($searchWord != '' && $category == ''){
									if ( $option == 'farmaco') {
										$prep_stmt=$pdo->prepare("SELECT * FROM Farmaco
																  WHERE nomeFarmaco LIKE :searchWord");
									} else {
										$prep_stmt=$pdo->prepare("SELECT * FROM Farmaco
																  WHERE nomeAzienda LIKE :searchWord");
											}
									$prep_stmt->bindValue(':searchWord', "%{$_POST['searchWord']}%"); //collegare parametro :searchWord alla variabile searchWord
								}
								//caso2
								if ($searchWord == '' && $category != ''){
									$prep_stmt=$pdo->prepare("SELECT * FROM PosizioneFarmaco JOIN Scaffale USING (n_scaf) 
															  WHERE categoria = :category");
									$prep_stmt->bindValue(':category', "{$_POST['category']}");								
								}
								//caso3
								if ($searchWord != '' && $category != ''){
									if ( $option == 'farmaco') {
										$prep_stmt=$pdo->prepare("SELECT * FROM PosizioneFarmaco JOIN Scaffale USING (n_scaf) 
																  WHERE PosizioneFarmaco.nomeFarmaco LIKE :searchWord 
																  AND Scaffale.categoria = :category");
									} else {
										$prep_stmt=$pdo->prepare("SELECT * FROM PosizioneFarmaco JOIN Scaffale USING (n_scaf) 
																  WHERE PosizioneFarmaco.nomeAzienda LIKE :searchWord 
																  AND Scaffale.categoria = :category");
										}
									$prep_stmt->bindValue(':searchWord', "%{$_POST['searchWord']}%");
									$prep_stmt->bindValue(':category', "{$_POST['category']}");
								}
								//previene il caso 4 ed esegue la query sul DB inserendo i risultati sulla var $farmaci
								if ($searchWord != '' || $category != ''){
									$prep_stmt->execute();
									$farmaci=$prep_stmt->fetchAll();
								}
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
			<!-- Sezione Header e Navbar -->
			<div class="headerCustom">
				<img class='logo' src="../img/logo.png">
				<h1 class="main-heading">Gestionale Posizione Farmacia</h1>
			</div>
			
			<!-- <ul>
				<li class='last-item-navbar'><a href="add-azienda.php">Gestione Aziende</a></li>
				<li><a href="add-farmaco.php">Gestione Farmaci</a></li>
				<li class='active first-item-navbar' ><a href="index.php">Cerca</a></li>
			</ul> -->

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
					<li><a href="#">Gestione Farmaci</a>
					<ul class="dropdown">
						<li class='firstSubItem'><a href="add-farmaco.php">Inserisci Farmaco</a></li>
						<li class='lastSubItem'><a href="rmv-farmaco.php">Elimina Farmaco</a></li>
					</ul>
					</li>
					<li class='active first-item-navbar'><a href="index.php">Cerca</a></li>
				</ul>
			</div> 

			<!-- Sezione Ricerca -->
			<div class="row center" style="background-color: #b4c0b4;">
				<p class="description">Trova il farmaco, cerca utilizzando il nome del farmaco, l'azienda produttrice oppure per categoria</p>
			</div>

			<div class="row center" style="background-color: #b4c0b4;">
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
					<input type="text" class=" search-bar-index " name="searchWord" id="searchBox" placeholder="Inserisci nome Farmaco o Azienda "/>
					<br />
					<br />
					<div class="radio-group ">
						<input checked type="radio" id="option-one" name="searchOption" value="farmaco"><label for="option-one">Farmaco</label><input type="radio" id="option-two" name="searchOption" value="azienda"><label for="option-two">Azienda</label>
					</div>
					 <select name="category" class="custom-select " placeholder="Tutte le categorie">
					 	<option value="">Tutte le categorie</option>
    					<option value="Sistema Cardiovascolare">Sistema Cardiovascolare</option>
    					<option value="Sistema Gastrointestinale e Metabolismo">Sistema Gastrointestinale e Metabolismo</option>
						<option value="Sangue e Organi Emopoietici">Sangue e Organi Emopoietici</option>
						<option value="Antineoplastici e Immunomodulatori">Antineoplastici e Immunomodulatori</option>
    					<option value="Sistema Nervoso Centrale">Sistema Nervoso Centrale</option>
    					<option value="Apparato Respiratorio">Apparato Respiratorio</option>
					  </select>	
					<input type="submit" class="btn search-button-mini" value="Cerca" name="submit"/>
				</form>
				<br />
			</div>
		</div>
		
		<!-- Sezione Risultati -->
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
								echo "<a class='link-farm center' href='details.php?nameF=$farmaco[nomeFarmaco]'>{$farmaco['nomeFarmaco']}, {$farmaco['nomeAzienda']}</a>";
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
	<script src="../js/index.js"></script>

</html>
