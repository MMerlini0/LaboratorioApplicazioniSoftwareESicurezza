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
			$query ="SELECT * from post  ORDER BY  datapubblicazione";
			$result=pg_query($query);
			$check=pg_num_rows($result);}}

			if (!isset($_SESSION['ruolo'])){
			$_SESSION['ruolo'] = '';}
?>
	<br>
	<?php  if (!empty($_SESSION['spotify_token'])) { ?>
		<div style="text-align: center;">
                    <a href="creapost.php" class="button" type="submit" value="Inserisci" id="inserisci">Crea Post</a>
                </div>
				<?php } ?>

	<div class="form-2" style="width:auto;margin-left: auto;margin-right: auto;">
	<form style="margin-top: -15px;" action="indexadmin.php" method="POST">
			<h3>Genere:   <select type="text" name="inputgenerefiltro" id="inputgenerefiltro" required>
								<option value="genere1">Genere 1</option>
								<option value="genere2">Genere 2</option>	
			</select>
			<button type="submit" class="btn btn-danger">  Applica</button></form></h3>
			<div>
			<form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search data">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>			</div>
        <div class="table-responsive-lg" style="border:5px outset;" >
            <table class="table table-bordered">
                <thead> 
                    <h1 style="text-align:center;color:black;">POST:</h1>
                <tbody >
		<?php 
			if($check >0){
				while ($row = pg_fetch_array($result)){
					  ?>
								<tr box >
									<td class="name"><?php echo $row['titolo']; ?></td>
									<td>
									<?php echo $row['contenuto']; ?> <br> </td>
									<td><?php echo $row['genere']; ?></td>
									<td><?php echo $row['datapubblicazione']; ?></td>
									<td><?php $creatore= $row['emailcreatore']; echo $row['emailcreatore']; ?></td>
									<?php  if (!empty($_SESSION['spotify_token']) && $creatore == 'scolamierod@gmail.com') { ?>
									<td><form style="margin-top: -15px;">
                                <a href="edit.php?utentepostid=<?php echo $row['postid']; ?>" class="btn btn-success">Modifica dati</a>
                    </form></td>
                            <td> 
                                <form style="margin-top: -15px;" action="code.php" method="POST">
                                <input type="hidden" name=utentedeleteid value="<?php echo $row['postid']; ?>">
                
								<?php } else{ ?>                    </form>
								</tr> <?php }
					}
					}else {
						echo "Nessun post disponibile";
					}
		?>
		</tbody>
            </table>
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