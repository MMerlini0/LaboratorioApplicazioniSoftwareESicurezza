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
<html>
    	<!-- Barra superiore-->
    <head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registrati</title>
    <link href="stile.css" rel="stylesheet">
    <link rel="icon" href="pictures/LogoEasyRail.jpg" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
    <body>
        <?php
                //Controlla se la connessione con il database è attiva 
            if ($dbconn) {
                //prende valore email dato dal form di registrazione
                $email = $_POST['InputEmail'];
                $id = $_SESSION['spotify_id'];
                $q1="select * from utente where email= $1";
                $result=pg_query_params($dbconn, $q1, array($email));
                //controlla se esiste nel DB utente
                if ($tuple=pg_fetch_array($result, null, PGSQL_ASSOC)) {?>
                    <!-- Messaggio di errore -->
                    <script >    
                    Swal.fire({
  title: "<strong>Errore nella registrazione</strong>",
  icon: "error",
  html: `<b>L'email  <?= $_POST['InputEmail']?> è già utilizzata</b>`,
  focusConfirm: false,
  confirmButtonText: `Riprova!`
}).then(function() {
    window.location = "profilo.php";
});

                    </script>
                <?php
                }
                //Se la registrazione è corretta inserisce tutto in DB
                else {
                    $paswd = $_POST['InputPassword'];
                    $ruolo = $_POST['InputRuolo'];
                    $nome =$_SESSION['spotify_nome'];
                    $canzone1=$_SESSION['canzone1'];
                    $canzone2=$_SESSION['canzone2'];
                    $canzone3=$_SESSION['canzone3'];
                    $artista1=$_SESSION['artista1'];
                    $artista2=$_SESSION['artista2'];
                    $artista3=$_SESSION['artista3'];
                    $q2 = "insert into utente values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)";
                    $data = pg_query_params($dbconn, $q2,
                        array($email, $nome, $paswd, $ruolo, $id, $canzone1 ,$canzone2,$canzone3,$artista1,$artista2,$artista3));
                    if ($data) {
                        ?>
                    	<!-- Messaggio di successo -->                      
                    <script >
                    Swal.fire({
  title: "<strong>I tuoi dati sono stati registrati correttamente</strong>",
  icon: "success",
  html: `<b>Dati inseriti!</b>`,
  focusConfirm: false,
  confirmButtonText: `Conferma!`
}).then(function() {
    window.location = "index.php";
});

                    </script> <?php
                    }
                }
            }
        ?> 
    </body>
</html>