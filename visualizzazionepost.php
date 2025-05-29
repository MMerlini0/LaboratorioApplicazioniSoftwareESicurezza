<!DOCTYPE html>
<?php 
session_start();
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");

$__app_secret = "a76619b8bddd432b9248fa0be1d4ce3a";
$__app_client_id = "05a4f7e97e5f4fd9bd130d40feb97392";
$__redirect_uri ="http://localhost:3000/callback/index.php";
$__base_url="https://accounts.spotify.com";
$__app_url="http://localhost:3000/index.php";
require '_inc/curl.class.php';
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Untuned</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="stile.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap">
	<link rel="icon" href="pictures/LogoEasyRail.jpg" type="image/x-icon">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="script.js" defer></script>
	<style>
		input {
			margin: 0;
			width: 240px;
		}
		main {
			background: url(pictures/back3.jpg) space;
			background-size: cover;
			background-position: top;
		}
	</style>
</head>
<body>
	<!--Barra superiore-->
	<header class="topnav">
		<nav>
			<a class="titolo" href="index.php">Untuned</a>
			<?php if (!empty($_SESSION['spotify_token'])) {
						$__cURL = new CurlServer();

						$nome = 'https://api.spotify.com/v1/me';
						
						$nome_user = $__cURL->get_request($nome, $_SESSION['spotify_token']->access_token);
						$_SESSION['spotify_nome'] = $nome_user->display_name;
						?>
						<div class="log dropdown">
							<button class="dropbtn"><?= $_SESSION['spotify_nome'] ?></button>
							<div class="dropdown-content">
							    <a href="articoli.php">Articoli</a>
								<a href="profilo.php">Area Personale</a>
								<a href="logout.php">Logout</a>
							</div>
						</div>
						<?php 
					}else if(isset($_SESSION['ruolo']) && $_SESSION['ruolo'] == 'Giornalista'){ ?>
						<div class="log dropdown">
							<button class="dropbtn"><?= $_SESSION['name']?></button>
							<div class="dropdown-content">
							<a href="articoli.php">Articoli</a>
						</div>
						<?php 
					}else{?>
				<div class="log dropdown">
					<button class="dropbtn">Accedi</button>
				<div class="dropdown-content">
					<a href="Loginform.php">Login</a>
					<a href="Register.html">Registrati</a>
				</div><?php if(isset($_SESSION['name']) && $_SESSION['name'] == 'Admin')
									header("location:Admin.php");?>
			</div>
			<?php }
			if(isset($_GET['search'])){
			$filtervalues = $_GET['search'];
			if(isset($_POST['inputgenerefiltro'])){
				$generefiltro=$_POST['inputgenerefiltro'];
				$query ="SELECT * from post WHERE genere='$generefiltro' titolo LIKE '%$filtervalues%' ORDER BY  datapubblicazione ";
			$result=pg_query($query);
			$check=pg_num_rows($result);
			}else{
			$query ="SELECT * from post WHERE titolo LIKE '%$filtervalues%' ORDER BY  datapubblicazione";
			$result=pg_query($query);
			$check=pg_num_rows($result);}
			}else{
			if(isset($_POST['inputgenerefiltro'])){
				$generefiltro=$_POST['inputgenerefiltro'];
				$query ="SELECT * from post WHERE genere='$generefiltro' ORDER BY  datapubblicazione ";
			$result=pg_query($query);
			$check=pg_num_rows($result);
			}else{
				$postid=$_GET['POSTID'];
			$query ="SELECT * from post where postid = '$postid'   ORDER BY  datapubblicazione";
			$result=pg_query($query);
			$check=pg_num_rows($result);}}

			if (!isset($_SESSION['ruolo'])){
			$_SESSION['ruolo'] = '';}
?>
		</nav>
	</header>
	<br>
	<?php  if (!empty($_SESSION['spotify_token'])) { ?>
		<div style="text-align: center;">
                    <a href="creapost.php" class="button" type="submit" value="Inserisci" id="inserisci">Crea Post</a>
                </div>
				<?php } ?>

	<div class="form-2" style="width:auto;margin-left: auto;margin-right: auto;">
        <div class="table-responsive-lg" style="border:5px outset;">
            <table class="table table-bordered">
                <thead>
                    <h1 style="text-align:center;color:black;">ID POST: #<?php $postid=$_GET['POSTID']; echo $_GET['POSTID'] ?></h1>
                <tbody>
                <?php
            if($check >0){
				while ($row = pg_fetch_array($result)){
					  ?>
								<tr box >
									<td class="name"><?php echo $row['titolo']; ?></td>
									<td><?php echo $row['contenuto']; ?></td>
									<td><?php echo $row['genere']; ?></td>
									<td><?php echo $row['datapubblicazione']; ?></td>
									<td><?php if (!isset($_SESSION['spotify_nome'])){
			$creatore='';} else{$creatore=$row['emailcreatore'];} echo $row['emailcreatore']; ?></td>
									<?php  if (!empty($_SESSION['spotify_token'])) { ?>
									<td><form style="margin-top: -15px;">
                                <a href="edit.php?utentepostid=<?php echo $row['postid']; ?>" class="btn btn-success">Modifica dati</a>
                    </form></td>
                            <td> 
                                <form style="margin-top: -15px;" action="code.php" method="POST">
                                <input type="hidden" name=utentedeleteid value="<?php echo $row['postid']; ?>">
                                <button type="submit" class="btn btn-danger">Cancella dati</button>
								<?php } else{ ?>
									<td><form style="margin-top: -15px;">
                                <button href="edit.php?utentepostid=<?php echo $row['postid']; ?>" class="btn btn-success" disabled>Modifica dati</l>
                    </form></td>
                            <td> 
                                <form style="margin-top: -15px;" action="code.php" method="POST">
                                <input type="hidden" name=utentedeleteid value="<?php echo $row['postid']; ?>">
                                <button type="submit" class="btn btn-danger" disabled>Cancella dati</button>
								
								</tr> <?php }
					}
					}else {
						echo "Nessun post disponibile";
					} ?>
	
        
		</tbody>
            </table><table class="table table-bordered">
                <thead>
                <?php  if (!empty($_SESSION['spotify_token'])) { ?>
		<div style="text-align: center;">
                    <a href="creacommento.php?utentepostid=<?php echo $postid ?>" class="button" type="submit" value="Inserisci" id="inserisci">Crea Commento</a>
                </div> <?php } ?>
                <h1>Commenti:</h1></thead>
                <tbody>
            <?php 
            $query3 ="SELECT * from commenti WHERE postid='$postid' ORDER BY  datacommento ";
            $result3=pg_query($query3);
            $check3=pg_num_rows($result3);
			if($check3 >0){
				while ($row3 = pg_fetch_array($result3)){
					  ?>
								<tr>
									<td class="name"><?php echo $row3['utenteemail']; ?></td>
									<td><?php echo $row3['contenuto']; ?></td>
									<td><?php echo $row3['orariocommento']; ?></td>
									<td><?php echo $row3['datacommento']; ?></td>
									<?php if($creatore==$row3['utenteemail']) { ?>
									<td><form style="margin-top: -15px;">
                                <a href="edit.php?utentepostidcommento=<?php echo $row3['commentiid']; ?>" class="btn btn-success">Modifica commento</a>
                    </form></td>
                            <td> 
                                <form style="margin-top: -15px;" action="code.php" method="POST">
                                <input type="hidden" name=utentedeleteidcommento value="<?php echo $row3['commentiid']; ?>">
                                <button type="submit" class="btn btn-danger">Cancella commento</button>
								<?php } else{ ?>
									<td><form style="margin-top: -15px;">
                                <button href="edit.php?utentepostidcommento=<?php echo $row3['commentiid']; ?>" class="btn btn-success" disabled>Modifica commento</l>
                    </form></td>
                            <td> 
                                <form style="margin-top: -15px;" action="code.php" method="POST">
                                <input type="hidden" name=utentedeleteidcommento value="<?php echo $row3['commentiid']; ?>">
                                <button type="submit" class="btn btn-danger" disabled>Cancella commento</button>
								
								</tr> <?php }
					}
					}else {
						echo "Nessun commento";
					}
		?>
        </tbody> </table>
        </div>
    </div>
	<main>
	<!--Parte inferiore-->
	<footer>
		<table>
			<tr>
				<td>
					<p>Untuned &copy;</p>
					<p>Un progetto per Laboratorio di Architetture Software e Sicurezza Informatica - A.A. 2023/24 - Prof. Daniele Cono D'Elia, Prof. Leonardo Querzoni</p>
				</td>
			<tr>	
				<td>Capitale Sociale 0&euro;. Fondatori: Merlini&DiCarlo&Scolamiero<p>Tutti i diritti riservati.</p></td>
				<td colspan="">Sede legale Università La Sapienza -	Edificio Marco Polo, Viale Scalo San Lorenzo, 82, Roma</td>
			</tr>
		</table>
	</footer>
	</main>
</body>
</html>