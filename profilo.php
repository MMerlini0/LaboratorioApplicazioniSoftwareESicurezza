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
        <div class="form-2" style="width:auto;margin-left: auto;margin-right: auto;padding:16px;">
            <h1 style="text-align:center;">Statistiche profilo</h1>
            <div class="container">
                <div class="row">
                    <div class="col-sm" style="text-align:center;">
                        <h2>Top 3 canzoni:</h2>
                        <?php  
                        $_SESSION['canzoni'] = [];
                        $req_url = 'https://api.spotify.com/v1/me/top/tracks';
                        $top_user_tracks = $__cURL->get_request($req_url, $_SESSION['spotify_token']->access_token);
                        foreach ($top_user_tracks as $content_value) {
                            if (is_array($content_value)) {
                                foreach ($content_value as $value) {
                                    $_SESSION['canzoni'][] = $value->id;
                                    echo "<div class='grid_item'>Titolo: {$value->name}<br/></div>";
                                    if (count($_SESSION['canzoni']) == 3) break 2;
                                }
                            }
                        }
                        $_SESSION['canzone1'] = $_SESSION['canzoni'][0];
                        $_SESSION['canzone2'] = $_SESSION['canzoni'][1];
                        $_SESSION['canzone3'] = $_SESSION['canzoni'][2];
                        ?>
                    </div>
                    <div class="col-sm" style="text-align:center;">
                        <h2>Top 3 artisti:</h2>
                        <?php
                        $_SESSION['artisti'] = [];
                        $req_url = 'https://api.spotify.com/v1/me/top/artists';
                        $top_user_artists = $__cURL->get_request($req_url, $_SESSION['spotify_token']->access_token);
                        foreach ($top_user_artists as $content_value) {
                            if (is_array($content_value)) {
                                foreach ($content_value as $value) {
                                    $_SESSION['artisti'][] = $value->id;
                                    echo "<div class='grid_item'>Artista: {$value->name}<br/></div>";
                                    if (count($_SESSION['artisti']) == 3) break 2;
                                }
                            }
                        }
                        $_SESSION['artista1'] = $_SESSION['artisti'][0];
                        $_SESSION['artista2'] = $_SESSION['artisti'][1];
                        $_SESSION['artista3'] = $_SESSION['artisti'][2];
                        ?>
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