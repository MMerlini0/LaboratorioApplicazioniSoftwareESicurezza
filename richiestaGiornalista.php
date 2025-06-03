<!DOCTYPE html>
<?php
session_start();
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");

// se non loggato rimando all’home
if (empty($_SESSION['spotify_nome']) || empty($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}

$emailCorrente = $_SESSION['email'];

// Verifico se esiste già una richiesta per questa email
$q = "SELECT 1 FROM richieste WHERE email = $1 LIMIT 1";
$richiestaPresente = pg_num_rows(pg_query_params($dbconn, $q, [$emailCorrente])) > 0;
?>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Untuned – Richiesta Giornalista</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="stile.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="pictures/LogoEasyRail.jpg"/>

    <style>
        input, textarea { margin: 0; width: 240px; }
        main { background:url(pictures/back3.jpg) space; background-size:cover; background-position:top; }
    </style>
</head>
<body>
<header class="topnav">
    <nav>
        <a class="titolo" href="index.php">Untuned</a>
        <a class="pulsantiNav" href="index.php">Home</a>
        <span style="margin:0 10px; border-left:3px solid #fff; height:20px;"></span>
        <a class="pulsantiNav" href="articoli.php">Articoli</a>

        <div class="log dropdown">
            <button class="dropbtn"><?= htmlspecialchars($_SESSION['spotify_nome']) ?></button>
            <div class="dropdown-content">
                <a href="profilo.php">Area Personale</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>
</header>

<main>
    <div class="container py-5">

        <?php if ($richiestaPresente): ?>
            <!-- L’utente ha già inviato una richiesta -->
            <div class="alert alert-info text-center">
                <h4 class="mb-0">Hai già mandato una richiesta.</h4>
            </div>

        <?php else: ?>
            <form action="code.php" method="POST" class="mx-auto" style="max-width: 500px;">
                <div class="formhead mb-3">MANDA LA TUA RICHIESTA</div>


                <input type="hidden" name="tokenRichiesta" value="true"/>
                <input type="hidden" name="inputemailcreatore" value="<?= htmlspecialchars($emailCorrente) ?>"/>

                <div class="mb-3 text-center">
                    <label for="inputcontenuto" class="form-label">Referenze</label>
                    <textarea class="form-control" id="inputcontenuto" name="inputcontenuto"
                            rows="6" required></textarea>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="button">Manda richiesta</button>
                    <button type="reset"  class="button">Annulla</button>
                </div>
            </form>
        <?php endif; ?>

    </div>

    <footer class="site-footer">
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
