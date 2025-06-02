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
			<a class="titolo" href="index.php">Untuned</a>
			<a class="pulsantiNav" href="index.php">Home</a>
			<span style="margin: 0 10px; border-left: 3px solid white; height: 20px; display: inline-flex;"></span>
			<a class="pulsantiNav" href="articoli.php">Articoli</a>
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
			<?php }if(isset($_GET['search'])){
			$filtervalues = $_GET['search'];
			if(isset($_POST['inputgenerefiltro'])){
				$generefiltro=$_POST['inputgenerefiltro'];
				$query ="SELECT * from articolo WHERE genere='$generefiltro' titolo LIKE '%$filtervalues%' ORDER BY  datapubblicazione ";
			$result=pg_query($query);
			$check=pg_num_rows($result);
			}else{
			$query ="SELECT * from articolo WHERE titolo LIKE '%$filtervalues%' ORDER BY  datapubblicazione";
			$result=pg_query($query);
			$check=pg_num_rows($result);}
			}else{
			if(isset($_POST['inputgenerefiltro'])){
				$generefiltro=$_POST['inputgenerefiltro'];
				$query ="SELECT * from articolo WHERE genere='$generefiltro' ORDER BY  datapubblicazione ";
			$result=pg_query($query);
			$check=pg_num_rows($result);
			}else{
			$query ="SELECT * from articolo  ORDER BY  datapubblicazione";
			$result=pg_query($query);
			$check=pg_num_rows($result);}} ?>
		</nav>
	</header>
	<br>
	<?php  if (!empty($_SESSION['spotify_token'])) { ?>
	<div style="text-align: center;">
                    <a href="creaarticolo.php" class="button" type="submit" value="Inserisci" id="inserisci">Crea Articolo</a>
                </div>
				<?php } ?>


	<!-- parte centrale -->
	<div class="form-2" style="width:auto;margin-left: auto;margin-right: auto; margin-bottom: 0;">
		<form style="margin-top: -15px; display: flex; justify-content: space-between; align-items: center;" action="index.php" method="POST">
			<h3 style="margin: 0; margin-right: auto;">Genere</h3>
			<div style="display: flex; align-items: center; margin-left: auto;">
				<select type="text" name="inputgenerefiltro" id="inputgenerefiltro" required style="width: 150px; height: 40px; font-size: 16px;">
					<option value="genere1">Genere 1</option>
					<option value="genere2">Genere 2</option>	
				</select>
				<button type="submit" class="btn btn-danger" style="margin-left: 10px;">Applica</button>
			</div>
		</form>
			<div>
			<form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search data">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
							</div>
    </div>
	<!-- intermedio -->
	<div class="form-2" style="width:auto;margin-left: auto;margin-right: auto;">
        <div class="table-responsive-lg" style="border:5px outset;">
            <table class="table table-bordered">
                <thead>
                    <h1 style="text-align:center;color:black;">ARTICOLI:</h1>
                <tbody>
				<?php 
    if ($check > 0) {
        while ($row = pg_fetch_array($result)) {
            $creatore = $row['emailcreatore'];
?>
<!-- Card wrapper replacing <tr> -->
<div class="article-card" onclick="location.href='visualizzazionearticolo.php?ARTICOLOID=<?php echo $row['articoloid']; ?>';">
    <!-- Titolo -->
    <div class="article-title">
        <?php echo htmlspecialchars($row['titolo'], ENT_QUOTES, 'UTF-8'); ?>
    </div>

    <!-- Corpo -->
    <div class="article-body">
        <?php echo nl2br(htmlspecialchars($row['contenuto'], ENT_QUOTES, 'UTF-8')); ?>
    </div>

    <!-- Footer: meta e azioni -->
    <div class="article-footer">
        <!-- Meta: genere, data e email -->
        <div class="article-meta">
            <span class="genre"><?php echo htmlspecialchars($row['genere'], ENT_QUOTES, 'UTF-8'); ?></span>
            <span class="date"><?php echo htmlspecialchars($row['datapubblicazione'], ENT_QUOTES, 'UTF-8'); ?></span>
            <span class="email"><?php echo htmlspecialchars($creatore, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>

        <!-- Azioni: Modifica/Cancella allineate a destra -->
        <div class="article-actions">
            <?php if (empty($_SESSION['spotify_token'])) { ?>
                <a href="edit.php?giornalistaarticoloid=<?php echo $row['articoloid']; ?>" class="btn btn-success">Modifica dati</a>
                <form action="code.php" method="POST" style="display:inline">
                    <input type="hidden" name="giornalistadeleteid" value="<?php echo $row['articoloid']; ?>">
                    <button type="submit" class="btn btn-danger">Cancella dati</button>
                </form>
            <?php } else { ?>
                <button class="btn btn-success" disabled>Modifica dati</button>
                <button class="btn btn-danger" disabled>Cancella dati</button>
            <?php } ?>
        </div>
    </div>
</div>

<?php   
        }
    } else {
        echo "<p>Nessun articolo disponibile</p>";
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