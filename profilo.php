<?php
session_start(); 
$__app_secret = "a76619b8bddd432b9248fa0be1d4ce3a";
$__app_client_id = "05a4f7e97e5f4fd9bd130d40feb97392";
$__redirect_uri ="http://localhost:3000/callback/index.php";
$__base_url="https://accounts.spotify.com";
$__app_url="http://localhost:3000/index.php";
require '_inc/curl.class.php';
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<main style="background: url(pictures/back3.jpg) no-repeat; background-size: cover; background-position: center;">
    <header class="topnav">
        <nav style="height:70px;">
            <a class="titolo" href="index.php">Untuned</a>
            <a class="pulsantiNav" href="index.php">Home</a>
            <span style="margin: 0 10px; border-left: 3px solid white; height: 20px; display: inline-flex;"></span>
            <a class="pulsantiNav" href="articoli.php">Articoli</a>
            <?php if(isset($_SESSION['name'])) { ?>
                <button class="dropbtn"><?= $_SESSION['name']?></button>
                <div class="dropdown-content">
                    <?php if($_SESSION['name'] == 'Admin') {
                        header("location:Admin.php");
                    } else { ?>
                        <a href="profilo.php">Area Personale</a>
                        <a href="logout.php">Logout</a>
                    <?php } ?>
                </div>
            <?php } elseif (!empty($_SESSION['spotify_token'])) {
                $__cURL = new CurlServer();
                $nome = 'https://api.spotify.com/v1/me';
                $nome_user = $__cURL->get_request($nome, $_SESSION['spotify_token']->access_token);
                $_SESSION['spotify_nome'] = $nome_user->display_name;
            ?>
                <div class="log dropdown">
                    <button class="dropbtn"><?= $_SESSION['spotify_nome'] ?></button>
                    <div class="dropdown-content">
                        <a href="profilo.php">Area Personale</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            <?php } else { ?>
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

    <body>
        <div class="form-2">
            <form>
                <h1 style="text-align:center;">Informazioni Utente</h1>
                <div class="table-responsive-lg" style="width:100%;">
                    <table class="table table-bordered">
                        <?php 
                        $__cURL = new CurlServer();
                        $nome = 'https://api.spotify.com/v1/me';
                        $nome_user = $__cURL->get_request($nome, $_SESSION['spotify_token']->access_token);
                        $_SESSION['spotify_nome'] = $nome_user->display_name;
                        $_SESSION['spotify_id'] = $nome_user->id;
                        ?>
                        <thead>
                            <tr>
                                <th>Nome a schermo</th>
                                <th>ID spotify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td><?= $_SESSION['spotify_nome']; ?></td>
                            <td><?= $nome_user->id; ?></td>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <div class="container my-5">
            <h1 class="text-center mb-4">Le Tue Statistiche Spotify</h1>
            <div class="row justify-content-center">
                <?php
                $nome = $_SESSION['spotify_nome'];
                $q = "SELECT canzone1, canzone2, canzone3, artista1, artista2, artista3 FROM utente WHERE nome = $1";
                $r = pg_query_params($dbconn, $q, array($nome));
                $stats = pg_fetch_array($r, NULL, PGSQL_ASSOC);
                ?>

                <!-- Top 3 Canzoni -->
                <div class="col-md-5 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white text-center" style="background-color: rgb(62 152 41) !important;">
                            <h4 class="mb-0">Top 3 Canzoni</h4>
                        </div>
                        <ul class="list-group list-group-flush text-center">
                            <li class="list-group-item"><?= $stats['canzone1'] ?? 'nessuna canzone'; ?></li>
                            <li class="list-group-item"><?= $stats['canzone2'] ?? 'nessuna canzone'; ?></li>
                            <li class="list-group-item"><?= $stats['canzone3'] ?? 'nessuna canzone'; ?></li>
                        </ul>
                    </div>
                </div>

                <!-- Top 3 Artisti -->
                <div class="col-md-5 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white text-center">
                            <h4 class="mb-0">Top 3 Artisti</h4>
                        </div>
                        <ul class="list-group list-group-flush text-center">
                            <li class="list-group-item"><?= $stats['artista1'] ?? 'nessun artista'; ?></li>
                            <li class="list-group-item"><?= $stats['artista2'] ?? 'nessun artista'; ?></li>
                            <li class="list-group-item"><?= $stats['artista3'] ?? 'nessun artista'; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
                    <!-- Post Creati -->
        <div class="form-2">
        <form>
            <h1 style="text-align:center;">Post creati</h1>
            <div class="table-responsive-lg" style="width:100%;">
                <br>
                <table hidden="hidden" class="table table-bordered"> <?php 
                $nome=$_SESSION['spotify_nome'];
                    $query ="SELECT * FROM post WHERE emailcreatore =(SELECT email from utente WHERE nome='$nome') ";
                    $result=pg_query($query);
                    $check=pg_num_rows($result); ?>
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
                                        <td><?php $creatore=$row['emailcreatore']; echo $row['emailcreatore']; ?></td>
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
                </table>
                
            </div>
        </form>
        
        <?php 
            //RICAVO EMAIL
            if (!empty($_SESSION['spotify_token'])) {
            $nome= $_SESSION['spotify_nome'];
            $q= "SELECT * from utente WHERE nome = $1 ";
            $r=pg_query_params($dbconn,$q,array($nome));
            $ro = pg_fetch_array($r,NULL,PGSQL_ASSOC);
            $email = $ro['email'];    }
        ?>
        <div style="text-align: center;">
                    <a href="index.php?email=<?php echo $email ?>" class="button" type="submit" value="Inserisci" id="inserisci">Mostra Post</a>
                    <a href="creapost.php" class="button" type="submit" value="Inserisci" id="inserisci">Crea Post</a>
                </div>
        </div>
                    <!-- Articoli Creati -->
        <div class="form-2">
        <form>
            <h1 style="text-align:center;">Articoli creati</h1>
            <div class="table-responsive-lg" style="width:100%;">
                <table hidden="hidden" class="table table-bordered"> <?php 
                $nome=$_SESSION['spotify_nome'];
                    $query ="SELECT * FROM articolo WHERE emailcreatore =(SELECT email from utente WHERE nome='$nome') ";
                    $result=pg_query($query);
                    $check=pg_num_rows($result); ?>
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
                                        <td><?php $creatore=$row['emailcreatore']; echo $row['emailcreatore']; ?></td>
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
                        }?>
            </tbody>                  
                </table>
                
            </div>
        </form>
        <div style="text-align: center;">
            <a href="articoli.php?email=<?php echo $email ?>" class="button" type="submit" value="Inserisci" id="inserisci">Mostra Articoli</a>
            <a href="creaarticolo.php" class="button" type="submit" value="Inserisci" id="inserisci">Crea Articolo</a>
        </div>
            </div><br>
            <?php
            if (!empty($_SESSION['spotify_token'])) {    
            $nome= $_SESSION['spotify_nome'];
            $q= "SELECT * from utente WHERE nome = $1 ";
            $r=pg_query_params($dbconn,$q,array($nome));
            $ro = pg_fetch_array($r,NULL,PGSQL_ASSOC);
            if($ro['ruolo'] != 'Giornalista'){?>
            <div style="text-align: center;">
                <a href="creapost.php" class="button" type="submit" value="Inserisci" id="inserisci">Richiedi Ruolo Giornalista</a>
            </div><?php }} ?>
        </div>

        <br><br><br>
        
        </body>
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
</html>