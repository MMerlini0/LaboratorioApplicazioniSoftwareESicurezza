<!DOCTYPE html>
<?php session_start();
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
			<a class="titolo" >Untuned</a>
					<div class="log dropdown">
						<button class="dropbtn">Admin</button>
					</div>
				<a class=" center" href="Admin.php">Area Admin</a>
				<a href="logout.php" style="margin-right: 1%;">  Logout</a>
			</nav>
		</header>

	<div>
	<form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;min-width:30%;">
                <div class="formhead">UPGRADE UTENTE</div>
				<input type="hidden" name=insertutentecommentoidpost value="<?php echo $row['numeroid'] + rand(); ?>">				<input type="hidden" name=inputorariopubblicazione value="<?php echo $ora; ?>">
				<input type="hidden" name=inputdatapubblicazione value="<?php echo $data; ?>">
				<input type="hidden" name=inputemailcreatore value="<?php echo $ro['email']; ?>">

                <table style="margin-left: auto;margin-right: auto;">
                    <tr>
                        <p>
                            <td><label for="inputcontenuto">ID Utente: </label></td>
                            <td><textarea type="text" name="inputcontenuto" id="inputcontenuto" required>
				</textarea>
							</td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputcontenuto">Ruolo Corrente: </label></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                        <td>
                            <label for="inputcontenuto">Nuovo Ruolo: </label>
                                <select type="text" name="inputgenerefiltro" id="inputgenerefiltro" required>
                                    <option value="genere1">Ruolo 1</option>
                                    <option value="genere2">Ruolo 2</option>	
                                </select>
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