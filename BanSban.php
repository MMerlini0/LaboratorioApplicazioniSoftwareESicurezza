<!DOCTYPE html>
<?php 
session_start();
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>EasyRail</title>
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
	</style>
</head>
<body>
	<main>
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
		<?php 
			// ACQUISIZIONE VARIABILE TIPO
			$tipo= $_GET['tipo'];
			
			//CONTROLLI
			if($tipo == 'banP'){ ?>
			<form action="code.php" method="POST" style="min-width:30%;margin-left: auto;margin-right: auto;">
                <h1 style="text-align:center;" >BAN dai Post</h1>
				<div style="text-align:center;">
				<p>
                            <td><label for="idpostban">Email utente: </label></td>
                            <td><input type="text" name="idpostban" id="idpostban" required></td>
                        </p>
            
			<div style="text-align: center;">
                    <input class="button" type="submit" value="Invia" id="inserisci">
					<input class="button" type="reset" value="Annulla" id="inserisci">
                </div>
			</form>
			<?php }
			else if($tipo == 'banA'){ ?>
			<form action="code.php" method="POST" style="min-width:30%;margin-left: auto;margin-right: auto;">
                <h1 style="text-align:center;" >BAN dagli Articolo</h1>
				<div style="text-align:center;">
				<p>
                            <td><label for="idarticoloban">Email utente: </label></td>
                            <td><input type="text" name="idarticoloban" id="idarticoloban" required></td>
                        </p>
			<div style="text-align: center;">
                    <input class="button" type="submit" value="Invia" id="inserisci">
					<input class="button" type="reset" value="Annulla" id="inserisci">
                </div>
			</form>
			<?php }
			else if($tipo == 'banU'){ ?>
			<form action="code.php" method="POST" style="min-width:30%;margin-left: auto;margin-right: auto;">
                <h1 style="text-align:center;" >Ban dalla piattaforma</h1>
				<div style="text-align:center;">
				<p>
                            <td><label for="idutenteban">Email utente: </label></td>
                            <td><input type="text" name="idutenteban" id="idutenteban" required></td>
                        </p>
			<div style="text-align: center;">
                    <input class="button" type="submit" value="Invia" id="inserisci">
					<input class="button" type="reset" value="Annulla" id="inserisci">
                </div>
			</form>
			<?php } else if($tipo == 'banC'){ ?>
			<form action="code.php" method="POST" style="min-width:30%;margin-left: auto;margin-right: auto;">
                <h1 style="text-align:center;" >BAN dai Commenti</h1>
				<div style="text-align:center;">
				<p>
                            <td><label for="idcommentoban">Email utente: </label></td>
                            <td><input type="text" name="idcommentoban" id="idcommentoban" required></td>
                        </p>
            
			<div style="text-align: center;">
                    <input class="button" type="submit" value="Invia" id="inserisci">
					<input class="button" type="reset" value="Annulla" id="inserisci">
                </div>
			</form>
			<?php } else if($tipo == 'sbanP'){ ?>
			<form action="code.php" method="POST" style="min-width:30%;margin-left: auto;margin-right: auto;">
                <h1 style="text-align:center;" >SBAN dai Post:</h1>
				<div style="text-align:center;">
				<p>
                            <td><label for="idpostsban">Email utente: </label></td>
                            <td><input type="text" name="idpostsban" id="idpostsban" required></td>
                        </p>
            
			<div style="text-align: center;">
                    <input class="button" type="submit" value="Invia" id="inserisci">
					<input class="button" type="reset" value="Annulla" id="inserisci">
                </div>
			</form>
			<?php } else if($tipo == 'sbanA'){ ?>
			<form action="code.php" method="POST" style="min-width:30%;margin-left: auto;margin-right: auto;">
                <h1 style="text-align:center;" >SBAN dagli Articoli</h1>
				<div style="text-align:center;">
				<p>
                            <td><label for="idarticolosban">Email utente: </label></td>
                            <td><input type="text" name="idarticolosban" id="idarticolosban" required></td>
                        </p>
            
			<div style="text-align: center;">
                    <input class="button" type="submit" value="Invia" id="inserisci">
					<input class="button" type="reset" value="Annulla" id="inserisci">
                </div>
			</form>
			<?php } else if($tipo == 'sbanC'){ ?>
			<form action="code.php" method="POST" style="min-width:30%;margin-left: auto;margin-right: auto;">
                <h1 style="text-align:center;" >SBAN dai Commenti:</h1>
				<div style="text-align:center;">
				<p>
                            <td><label for="idcommentosban">Email utente: </label></td>
                            <td><input type="text" name="idcommentosban" id="idcommentosban" required></td>
                        </p>
            
			<div style="text-align: center;">
                    <input class="button" type="submit" value="Invia" id="inserisci">
					<input class="button" type="reset" value="Annulla" id="inserisci">
                </div>
			</form>
			<?php } else if($tipo == 'sbanU'){ ?>
			<form action="code.php" method="POST" style="min-width:30%;margin-left: auto;margin-right: auto;">
                <h1 style="text-align:center;" >SBAN dalla piattaforma dell'utente</h1>
				<div style="text-align:center;">
				<p>
                            <td><label for="idutentesban">Email Utente: </label></td>
                            <td><input type="text" name="idutentesban" id="idutentesban" required></td>
                        </p>
            
			<div style="text-align: center;">
                    <input class="button" type="submit" value="Invia" id="inserisci">
					<input class="button" type="reset" value="Annulla" id="inserisci">
                </div>
			</form>
			<?php } ?>
</body>
</html>