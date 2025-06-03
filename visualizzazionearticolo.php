<?php 
session_start();
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");

$__app_secret = "a76619b8bddd432b9248fa0be1d4ce3a";
$__app_client_id = "05a4f7e97e5f4fd9bd130d40feb97392";
$__redirect_uri ="http://localhost:3000/callback/index.php";
$__base_url="https://accounts.spotify.com";
$__app_url="http://localhost:3000/index.php";
require '_inc/curl.class.php';

$articoloid = isset($_GET['ARTICOLOID']) ? intval($_GET['ARTICOLOID']) : 0;
if (!isset($_SESSION['ruolo'])) $_SESSION['ruolo'] = '';
?>

<!DOCTYPE html>
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
</head>
<body>
<header class="topnav">
	<nav>
		<a class="titolo" href="index.php">Untuned</a>
			<a class="pulsantiNav" href="index.php">Home</a>
			<span style="margin: 0 10px; border-left: 3px solid white; height: 20px; display: inline-flex;"></span>
			<a class="pulsantiNav" href="articoli.php">Articoli</a>
		<?php
		if (!empty($_SESSION['spotify_token'])) {
			$__cURL = new CurlServer();
			$nome_user = $__cURL->get_request("https://api.spotify.com/v1/me", $_SESSION['spotify_token']->access_token);
			$_SESSION['spotify_nome'] = $nome_user->display_name;
			?>
			<div class="log dropdown">
				<button class="dropbtn"><?= $_SESSION['spotify_nome'] ?></button>
				<div class="dropdown-content">
					
					<a href="profilo.php">Area Personale</a>
					<a href="logout.php">Logout</a>
				</div>
			</div>
		<?php }else { ?>
			<div class="log dropdown">
				<button class="dropbtn">Accedi</button>
				<div class="dropdown-content">
					<a href="Loginform.php">Login</a>
					<a href="Register.html">Registrati</a>
				</div>
			</div>
		<?php } if (!empty($_SESSION['spotify_token'])) {
	$nome= $_SESSION['spotify_nome'];
	$q= "SELECT * from utente WHERE nome = $1 ";
	$r=pg_query_params($dbconn,$q,array($nome));
	$ro = pg_fetch_array($r,NULL,PGSQL_ASSOC); 
	$email = $ro['email'];
	} ?>
	</nav>
</header>
<br>

<div class="form-2">
	<h1 style="text-align:center;color:black;">ID ARTICOLO: #<?= $articoloid ?></h1>
	<?php
	$query = "SELECT * FROM articolo WHERE articoloid = $articoloid ORDER BY datapubblicazione";
	$result = pg_query($query);
	$check = pg_num_rows($result);
	if ($check > 0) {
		while ($row = pg_fetch_array($result)) {
			$creatore = $row['emailcreatore'];
	?>
		<div class="article-card">
			<div class="article-title"><?= htmlspecialchars($row['titolo']) ?></div>
			<div class="article-body"><?= nl2br(htmlspecialchars($row['contenuto'])) ?></div>
			<div class="article-footer">
				<div class="article-actions" style="display: flex; gap: 1rem; align-items: center;">
					<?php if (!empty($_SESSION['spotify_token']) && $creatore == $email) { ?>
						<a href="edit.php?utentearticoloid=<?= $row['articoloid'] ?>" class="btn btn-success">Modifica</a>
						<form action="code.php" method="POST" style="display:inline;">
							<input type="hidden" name="utentedeleteid" value="<?= $row['articoloid'] ?>">
							<button type="submit" class="btn btn-danger">Elimina</button>
						<a href="creacommentoarticolo.php?utentearticoloid=<?= $row['articoloid'] ?>" class="btn btn-primary">Commenta</a></form>
					<?php }else if(!empty($_SESSION['spotify_token'])){ ?>
						<form action="code.php" method="POST" style="display:inline;">
						<a href="creacommentoarticolo.php?utentearticoloid=<?= $row['articoloid'] ?>" class="btn btn-primary">Commenta</a>
						</form>
								<?php } ?>
					
				</div>
				<div class="article-meta text-muted" style="font-size: 0.8rem;">
					<?= htmlspecialchars($creatore) ?> | <?= htmlspecialchars($row['datapubblicazione']) ?>
				</div>
			</div>
		</div>
	<?php
		}
	} else {
		echo "<p>Nessun articolo disponibile</p>";
	}
	?>
</div>

<div class="form-2">
	<h2 style="text-align: center;">Commenti:</h2>
	<?php
	$query3 = "SELECT * FROM commenti WHERE articoloid=$articoloid ORDER BY datacommento";
	$result3 = pg_query($query3);
	$check3 = pg_num_rows($result3);
	if ($check3 > 0) {
		while ($row3 = pg_fetch_array($result3)) {
	?>
		<div class="post-card" style="min-height: auto;">
			<div class="post-body"><?= nl2br(htmlspecialchars($row3['contenuto'])) ?></div>
			<div class="post-footer">
				<div class="post-actions" style="display: flex; gap: 1rem; align-items: center;">
					<?php if (!empty($_SESSION['spotify_token']) && $row3['utenteemail'] === $_SESSION['email']) { ?>
						<a href="edit.php?utentearticoloidcommento=<?= $row3['commentiid'] ?>" class="btn btn-success">Modifica</a>
						<form action="code.php" method="POST" style="display:inline;">
							<input type="hidden" name="utentedeleteidcommento" value="<?= $row3['commentiid'] ?>">
							<button type="submit" class="btn btn-danger">Elimina</button>
						</form>
					<?php } ?>
				</div>
				<div class="post-meta text-muted" style="font-size: 0.8rem;">
					<?= htmlspecialchars($row3['utenteemail']) ?> | <?= htmlspecialchars($row3['datacommento']) ?> <?= htmlspecialchars($row3['orariocommento']) ?>
				</div>
			</div>
		</div>
	<?php
		}
	} else {
		echo "<p style='text-align:center;'>Nessun commento</p>";
	}
	?>
</div>

<main>
<footer>
	<table>
		<tr>
			<td>
				<p>Untuned &copy;</p>
				<p>Un progetto per Laboratorio di Architetture Software e Sicurezza Informatica - A.A. 2023/24 - Prof. Daniele Cono D'Elia, Prof. Leonardo Querzoni</p>
			</td>
		<tr>	
			<td>Capitale Sociale 0&euro;. Fondatori: Merlini&DiCarlo&Scolamiero<p>Tutti i diritti riservati.</p></td>
			<td>Sede legale Università La Sapienza - Edificio Marco Polo, Viale Scalo San Lorenzo, 82, Roma</td>
		</tr>
	</table>
</footer>
</main>
</body>
</html>
