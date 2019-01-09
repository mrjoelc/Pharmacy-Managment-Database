<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Gestionale Posizione Farmacia</title>
		<!--External stylesheet links-->
        <link rel="stylesheet" href="../css/styles.css?<?php echo time(); ?>">
        <link rel="stylesheet" href="../css/rmv-farmaco-details.css?<?php echo time(); ?>">

		<?php
			if (isset($_GET['nameF'])) {
					try {
						//Connessione al DB & setup debugging mode
						$pdo = new PDO("mysql:host=localhost; dbname=Farmacia", "root", "root");
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						$prep_stmt=$pdo->prepare("SELECT * FROM Farmaco JOIN PosizioneFarmaco using (nomeFarmaco) JOIN Scaffale using (n_scaf)
												  WHERE nomeFarmaco = :nameF");
						
						$prep_stmt->bindValue(':nameF', "{$_GET['nameF']}");

						$prep_stmt->execute();
						$farmaco=$prep_stmt->fetch();

					}catch (PDOException $e) {
						echo 'Connection error: '.$e->getMessage();
						exit();
					}

					$pdo = null; 
		
                }
            if(isset($_POST['submit'])){
                try {
                    //Connessione al DB & setup debugging mode
                    $pdo = new PDO("mysql:host=localhost; dbname=Farmacia", "root", "root");
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $prep_stmt=$pdo->prepare("DELETE FROM Farmaco WHERE nomeFarmaco = :nameF");
                    
                    $prep_stmt->bindValue(':nameF', "{$_GET['nameF']}");

                    $prep_stmt->execute();

                    if ($prep_stmt->execute()){
                        echo "<script type= 'text/javascript'>alert('Farmaco eliminato correttamente!');</script>";
                        echo "<script> location.href='rmv-farmaco.php'; </script>";
                        exit;
                    }else{
                        echo "<script type= 'text/javascript'>alert('Farmaco non eliminato!');</script>";
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
					<li class='active'><a  href="#">Gestione Farmaci</a>
					<ul class="dropdown">
						<li class='firstSubItem'><a href="add-farmaco.php">Inserisci Farmaco</a></li>
						<li class='lastSubItem'><a href="rmv-farmaco.php">Elimina Farmaco</a></li>
					</ul>
					</li>
					<li class='first-item-navbar'><a href="index.php">Cerca</a></li>
				</ul>
			</div> 
		

		<!-- Sezione NOME FARMACO -->
			<div class='nameContainer' style="background-color: #b4c0b4;">
				<?php if ($farmaco){ echo "<h1 class='center nameOf'>$farmaco[nomeFarmaco]</h1>";} 
					  else { echo "<h1 class='center nameOf'>Ci deve essere un errore</h1>";} ?>
			</div>

		<!-- Sezione DETTAGLI FARMACO -->
			<div id="detailsContainer">

				<p class='category'>Azienda produttrice:</p>
				<a class='attribute attributeLink' href='azienda.php?nameA=<?php echo "$farmaco[nomeAzienda]";?>'> <?php echo"$farmaco[nomeAzienda]";?> </a>

				<p class='category'>Categoria d'appartenenza farmaco</p>
				<a class='attribute'> <?php echo"$farmaco[categoria]"; ?> </a>


				<p class='category'>Impiego ed utilizzo</p>
				<p class='attribute'> <?php echo"$farmaco[impiego]"; ?> </p>


				<p class='category'>Data Scadenza</p>
				<p class='attribute'> <?php echo"$farmaco[dataScadenza]"; ?> </p>

				<p class='category'>Posizione</p>
				<p class='attribute'> Cassetto n. <?php echo"$farmaco[n_cass]";?>, Scaffale n. <?php echo"$farmaco[n_scaf]";?></p>
                
                <!-- Tasto cancella -->
                <form method="POST" style='display:flex; justify-content:center;'><input style='width:70%;' type="submit" class="button-rmv" value="Cancella" name="submit"/></form>

			</div>

	</body>

</html>
