<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Gestionale Posizione Farmacia</title>
		<!--External stylesheet links-->
		<link rel="stylesheet" href="../css/styles.css?<?php echo time(); ?>">
        <link rel="stylesheet" href="../css/rmv-farmaco-details.css?<?php echo time(); ?>">

		<?php
			if (isset($_GET['nameA'])) {
					try {
						//Connessione al DB & setup debugging mode
						$pdo = new PDO("mysql:host=localhost; dbname=Farmacia", "root", "root");
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						$prep_stmt=$pdo->prepare("SELECT * FROM Azienda WHERE nomeAzienda = :nameA");
						
						$prep_stmt->bindValue(':nameA', "{$_GET['nameA']}");

						$prep_stmt->execute();
						$azienda=$prep_stmt->fetch();

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

                    $prep_stmt=$pdo->prepare("DELETE FROM Azienda WHERE nomeAzienda = :nameA");
                    
                    $prep_stmt->bindValue(':nameA', "{$_GET['nameA']}");

                    $prep_stmt->execute();

                    if ($prep_stmt->execute()){
                        echo "<script type= 'text/javascript'>alert('Azienda eliminata correttamente!');</script>";
                        echo "<script> location.href='rmv-azienda.php'; </script>";
                        exit;
                    }else{
                        echo "<script type= 'text/javascript'>alert('Azienda non eliminata!');</script>";
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
		

		<!-- Sezione NOME AZIENDA -->
			<div class='nameContainer' style="background-color: #b4c0b4;">
				<?php if ($azienda){ echo "<h1 class='center nameOf'>$azienda[nomeAzienda]</h1>";} 
					  else { echo "<h1 class='center nameOf'>Ci deve essere un errore</h1>";} ?>
			</div>

		<!-- Sezione DETTAGLI FARMACO -->
			<div id="detailsContainer">
				<p class='category'>Recapito Telefonico</p>
				<p class='attribute'> <?php echo"$azienda[recapitoTel]";?> </p>

				<p class='category'>Email</p>
                <p class='attribute'> <?php echo"$azienda[email]"; ?> </p>
                
                 <!-- Tasto cancella -->
                 <p class='category' style='color: red; display:flex; justify-content:center; margin-top:10px;'>Tutti i farmaci ad essa collegata verranno rimossi dal sistema!</p>
                 <form method="POST" style='display:flex; justify-content:center; margin-top:10px;'><input style='width:70%;' type="submit" class="button-rmv" value="Cancella" name="submit"/></form>

            </div>

            

	</body>

</html>
