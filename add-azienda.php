<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Gestionale Posizione Farmacia</title>
		<!--External stylesheet links-->
		<link rel="stylesheet" href="../css/add-farmaco.css?<?php echo time(); ?>">
		<link rel="stylesheet" href="../css/styles.css?<?php echo time(); ?>">
	
		<?php
			if(isset($_POST['submit'])){
				try{
					$pdo = new PDO("mysql:host=localhost; dbname=Farmacia", "root", "root");
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$nomeAzienda = $_POST['nomeAzienda'];
					$recapitoTel = $_POST['recapitoTel'];
					$email = $_POST['email'];
					
					$stmt = $pdo->prepare("SELECT * FROM Azienda WHERE nomeAzienda=:nomeAzienda");
					$stmt->execute(['nomeAzienda' => $nomeAzienda]); 
					$duplicate = $stmt->fetchAll();
					if ($duplicate) {
						$nc = count($duplicate);
					}
					if($nc < 1){
						$sql= "INSERT INTO Azienda(nomeAzienda, recapitoTel, email) VALUES ('$nomeAzienda', '$recapitoTel',' $email')";
						if ($pdo->query($sql)) {
							echo "<script type= 'text/javascript'>alert('Azienda inserita correttamente!');</script>";
						   } 
						else{
							echo "<script type= 'text/javascript'>alert('Azienda non inserita correttamente! Riprovare.');</script>";
						 }
					}else{
						echo "<script type= 'text/javascript'>alert('Azienda non inserita! Già è presente nel sistema.');</script>";
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
			</div> 

			<form style='background-color: #b4c0b4; margin-top:30px;' action="<?php $_SERVER['PHP_SELF'] ?>" method="POST"> 
			<!-- Sezione NOME FARMACO -->
			<div class='nameContainer' style="margin-top:0px; background-color: #b4c0b4;">
				<input required="required" type="text" class="nameBig" name="nomeAzienda" id="searchBox" placeholder="Inserisci nome Azienda"/>
			</div>

			<!-- Sezione DETTAGLI Azienda -->
			<div id="detailsContainer">

				<p class='category'>Recapito Telefonico</p>
				<input required="required" type="text" class="attributeInput" name="recapitoTel"  style='padding-top:8px; padding-bottom:5px; margin-bottom:10px;' placeholder="Inserisci qui"/>

				<p class='category'>Email</p>
				<input required="required" type="text" class="attributeInput" name="email"  style=' padding-top:8px; padding-bottom:5px; margin-bottom:10px;' placeholder="Inserisci qui"/>
				
				<input type="submit" class="registration-button" value="Registra" name="submit"/>

			</div>
		</form>

		
		</div>

	</body>


</html>
