<!DOCTYPE html>
<?php session_start();
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432"); 
$__app_secret = "a76619b8bddd432b9248fa0be1d4ce3a";
$__app_client_id = "05a4f7e97e5f4fd9bd130d40feb97392";
$__redirect_uri ="http://localhost:3000/callback/index.php";
$__base_url="https://accounts.spotify.com";
$__app_url="http://localhost:3000/index.php";
require '_inc/curl.class.php';


$nome = $_SESSION['spotify_nome'];
$email = $_SESSION['email'];
$query = "SELECT bancommenti FROM utente WHERE nome = $1 AND email = $2";
$res = pg_query_params($dbconn, $query, [$nome, $email]);


if ($res && pg_num_rows($res) > 0) {
    $row = pg_fetch_assoc($res);
    if ($row['bancommenti'] === 't') {
        // L'utente è bannato dagli articoli
        ?>
        <!DOCTYPE html><html lang="it"><head>
            <meta charset="UTF-8">
            <title>Accesso Negato</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <meta name="viewport" content="width=device-width,initial-scale=1">
            <style>body{margin:0;background:#f5f5f5;}</style>
        </head><body>
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Sezione bloccata',
                text: 'Sei stato bannato dalla creazione di commenti.',
                showConfirmButton: false,
                timer: 2500
            }).then(() => window.location.href = 'index.php');
            </script>
        </body></html>
        <?php
		exit;
	}
}


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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="funzioni.js"></script>
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
					}else if($_SESSION['ruolo'] == 'Giornalista'){ ?>
						<div class="log dropdown">
							<button class="dropbtn"><?= $_SESSION['name']?></button>
							<div class="dropdown-content">
							<a href="articoli.php">Articoli</a>
							<?php if($_SESSION['name'] == 'Admin'){ 
									header("location:Admin.php");?>
								<?php }else{?>
								<a href="logout.php">Logout</a>
								<?php } ?>
							</div>
						</div>
						<?php 
					}else{?>
				<div class="log dropdown">
					<button class="dropbtn">Accedi</button>
				<div class="dropdown-content">
					<a href="Loginform.php">Login</a>
					<a href="Register.html">Registrati</a>
				</div>
			</div>
			<?php } ?>
		</nav>
	</header>

	<div>
		<?php $query="SELECT count(*) as numeroid from commenti"; 
		$result=pg_query($dbconn,$query);
		$row = pg_fetch_array($result,NULL,PGSQL_ASSOC);
		$ora= date("H:i:s");
		$data= date("Y-m-d");
		$nome= $_SESSION['spotify_nome'];
		$q= "SELECT * from utente WHERE nome = $1 ";
		$r=pg_query_params($dbconn,$q,array($nome));
		$ro = pg_fetch_array($r,NULL,PGSQL_ASSOC);
		?>
	<form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;min-width:30%;">
                <div class="formhead">CREA COMMENTO</div>
				<input type="hidden" name="tokenCommento" value="true">
                <input type="hidden" name=inpututentepostid value="<?php echo $_GET['utentepostid']; ?>">
				<input type="hidden" name=inputorariopubblicazione value="<?php echo $ora; ?>">
				<input type="hidden" name=inputdatapubblicazione value="<?php echo $data; ?>">
				<input type="hidden" name=inputemailcreatore value="<?php echo $ro['email']; ?>">

                <table style="margin-left: auto;margin-right: auto;">
                    <tr>
                        <p>
                            <td><label for="inputcontenuto">Commento: </label></td>
                            <td><textarea type="text" name="inputcontenuto" id="inputcontenuto" required>
				</textarea>
							</td>
                        </p>
                    </tr>
                </table>
                <p>
                <div style="text-align: center;">
                    <input class="button" type="submit" value="Invia" id="inserisci">
					<input class="button" type="reset" value="Annulla" id="inserisci">
                </div>
                <p></div>
            </form>
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