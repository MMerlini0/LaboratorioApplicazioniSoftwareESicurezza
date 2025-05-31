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
		<!-- Diversi Form per l'inserimento e la visualizzazione dei dati -->
		
			<div style="text-align:center;"></div><table style="width:100%;"></table>
            <tr><td style="width:50%;"></td><form style="min-width:30%;margin-left: auto;margin-right: auto;">
                <h1 style="text-align:center;" >SEZIONE BAN</h1>
				<div style="text-align:center;">
				<a  class=button href="BanSban.php?tipo=banP">BAN POST</a></div> <br>
                <div style="text-align:center;"><a  class=button href="BanSban.php?tipo=banA">BAN ARTICOLI</a></div>
				<br><div style="text-align:center;"><a  class=button href="BanSban.php?tipo=banC">BAN COMMENTI</a></div>
				<br><div style="text-align:center;"><a  class=button href="BanSban.php?tipo=banU">BAN UTENTE</a></div>
				</td>
            </form>
				<tr><td style="width:50%;">
            <form>
                <h1 style="text-align:center;">SEZIONE SBAN</h1>
				<div style="text-align:center;">
				<div style="text-align:center;">
				<a  class=button href="BanSban.php?tipo=sbanP">SBAN POST</a></div> <br>
                <div style="text-align:center;"><a  class=button href="BanSban.php?tipo=sbanA">SBAN ARTICOLI</a></div>
				<br><div style="text-align:center;"><a  class=button href="BanSban.php?tipo=sbanC">SBAN COMMENTI</a></div>
				<br><div style="text-align:center;"><a  class=button href="BanSban.php?tipo=sbanU">SBAN UTENTE</a></div>

            </form>
					</td>
			</table>
</body>
</html>