<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Gestionale Posizione Farmacia</title>
		<!--External stylesheet links-->
		<link rel="stylesheet" href="../css/styles.css?<?php echo time(); ?>">
		<link rel="stylesheet" href="../css/add-farmaco.css?<?php echo time(); ?>">
		<script type="text/javascript" src="http://services.iperfect.net/js/IP_generalLib.js"></script>
	


		<?php
			try {
				//Connessione al DB & setup debugging mode
				$pdo = new PDO("mysql:host=localhost; dbname=Farmacia", "root", "root");
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$prep_stmt=$pdo->prepare("SELECT nomeAzienda FROM Azienda");
				$prep_stmt->execute();
				$aziende=$prep_stmt->fetchAll();

				$prep_stmt=$pdo->prepare("SELECT * FROM Scaffale");
				$prep_stmt->execute();
				$categorie=$prep_stmt->fetchAll();

				$prep_stmt=$pdo->prepare("SELECT DISTINCT n_cass FROM Cassetto");
				$prep_stmt->execute();
				$cassetti=$prep_stmt->fetchAll();
				
				$pdo = null; 
			}catch (PDOException $e) {
				echo 'Connection error: '.$e->getMessage();
				exit();
			}

			if(isset($_POST['submit'])){
				try{
					$pdo = new PDO("mysql:host=localhost; dbname=Farmacia", "root", "root");
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$nomeFarmaco = $_POST['nomeFarmaco'];
					$nomeAzienda = $_POST['nomeAzienda'];
					$impiego = $_POST['impiego'];
					$dataScadenza = $_POST['dataScadenza'];
					$n_scaf = $_POST['n_scaf'];
					$n_cass = $_POST['n_cass'];
					
					$stmt = $pdo->prepare("SELECT * FROM Farmaco WHERE nomeFarmaco=:nomeFarmaco AND nomeAzienda=:nomeAzienda");
					$stmt->execute(['nomeFarmaco' => $nomeFarmaco, 'nomeAzienda' => $nomeAzienda,]); 
					$duplicate = $stmt->fetchAll();
					if ($duplicate) {
						$nc = count($duplicate);
					}
					if($nc < 1){
						$sqlF= "INSERT INTO Farmaco(nomeFarmaco, nomeAzienda, impiego, dataScadenza) VALUES ('$nomeFarmaco', '$nomeAzienda', '$impiego',' $dataScadenza')";
						$sqlPF= "INSERT INTO PosizioneFarmaco(nomeFarmaco, nomeAzienda, n_cass, n_scaf) VALUES ('$nomeFarmaco', '$nomeAzienda', '$n_cass',' $n_scaf')";
						if ($pdo->query($sqlF) && $pdo->query($sqlPF)) {
							echo "<script type= 'text/javascript'>alert('Farmaco inserito correttamente!');</script>";
						   } 
						else{
							echo "<script type= 'text/javascript'>alert('Farmaco non inserito correttamente! Riprovare.');</script>";
						 }
					}else{
						echo "<script type= 'text/javascript'>alert('Farmaco non inserito! Già è presente nel sistema.');</script>";
					 }				   
					$pdo = null; 
				}catch (PDOException $e) {
					echo 'Connection error: '.$e->getMessage();
				exit();
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
		
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST"> 
			<!-- Sezione NOME FARMACO -->
			<div class='nameContainer' style="background-color: #b4c0b4;">
				<input required="required" type="text" class="nameBig" name="nomeFarmaco" id="searchBox" placeholder="Inserisci nome Farmaco"/>
			</div>

			<!-- Sezione DETTAGLI FARMACO -->
			<div id="detailsContainer">

				<p class='category'>Azienda produttrice</p>
				<div class="select-style" style='width:250px;'>
					<select name='nomeAzienda'>
						<?php
							foreach( $aziende as $azienda) 
							echo "<option value='$azienda[nomeAzienda]'>$azienda[nomeAzienda]</option>";
							?>
					</select>
				</div>

				<div class='scaff'> 
					<p class='category'>Categoria d'appartenenza farmaco</p>
					<div class="select-style" style='width: 400px; margin-bottom:10px;'>
						<select name='n_scaf'>
							<?php
								foreach( $categorie as $categoria) 
								echo "<option value='$categoria[n_scaf]'>$categoria[categoria]</option>";
							?>
						</select>
					</div>
				</div>

				<div class='impiego'> 
					<p class='category'>Impiego ed utilizzo</p>
					<input required="required" type="text" class="attributeInput" name="impiego"  style=' padding-top:8px; padding-bottom:5px; margin-bottom:10px;' placeholder="Inserisci qui"/>
				</div>
				
				<div class='dataPicker'> 
					<p class='category'>Data Scadenza</p>
					<input stylerequired="required" type="text" name="dataScadenza" class="IP_calendar dataInput" placeholder="Clicca qui" title="Y/m/d">
				</div>
				
				<p class='category'>Numero cassetto</p>
				<div class="select-style">
					<select name=n_cass>
						<?php
							foreach( $cassetti as $cassetto) 
							echo "<option value='$cassetto[n_cass]'>$cassetto[n_cass]</option>";
						?>
					</select>
				</div>
				
				<input type="submit" class="registration-button" value="Registra" name="submit"/>

			</div>
		</form>
		
	</body>


</html>
