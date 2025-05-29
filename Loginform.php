<!DOCTYPE html>
<?php 
	$__app_secret = "a76619b8bddd432b9248fa0be1d4ce3a";
	$__app_client_id = "05a4f7e97e5f4fd9bd130d40feb97392";
	$__redirect_uri ="http://localhost:3000/callback/index.php";
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Accedi</title>
	<link href="stile.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
	<link rel="icon" href="pictures/LogoEasyRail.jpg" type="image/x-icon">
</head>
<body>
	<!-- Barra superiore-->
	<header class="topnav">
		<nav>	
			<a class="titolo" href="HomePage.php" ALT="EasyRail">Untuned</a>
			<div class="log dropdown">
				<button class="dropbtn">Accedi</button>
				<div class="dropdown-content">
					<a href="articoli.php">Articoli</a>
					<a href="Login.html" class="center" >Login</a>
					<a href="Register.html">Registrati</a>
				</div>
			</div>
		</nav>
	</header>
	<main>
			<!-- Form con inserimento credenziali-->
		<form action="login.php" method="post" style="margin-top: 60px auto 60px auto;min-width: 30%;">
			<div class="formhead">Accedi con le tue credenziali</div>
			<table style="margin-left: auto;margin-right: auto;">
				<tr>
					<p>
					<td><label for="email">Email </label></td>
					<td><input type="email" name="InputEmail" id="email" required></td>
					</p>
				</tr>
				<tr>
					<p>
					<td><label for="pw">Password </label></td>
					<td><input type="password" name="InputPassword" id="pw" required></td>
					</p>
				</tr>
			</table>
			<p>
				<div style="text-align: center;">
				<input class="button" type="submit" value="Cerca" id="cerca">
				</div>
			</p>
			<p>
				<div style="text-align: center;">
				<input class="button" type="submit" onclick="userLogInRequest();" value="Spotify Log in" id="cerca">
				</div>
			</p>
		</form>
	</main>
		<!--Parte inferiore-->
		<footer>
		<script>
    // User log in request on button click
    const userLogInRequest = () => {
        let logInUri = 'https://accounts.spotify.com/authorize' +
            '?client_id=<?php echo $__app_client_id; ?>' +
            '&response_type=code' +
            '&redirect_uri=<?php echo $__redirect_uri; ?>' +
            '&scope=app-remote-control user-top-read user-read-currently-playing user-read-recently-played streaming app-remote-control user-read-playback-state user-modify-playback-state' +
            '&show_dialog=true';
        // Debug
        console.log(logInUri);
        
        // Open URL to request user log in from Spotify
        window.open(logInUri, '_self');
    }
</script>
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
	
</body>
</html>