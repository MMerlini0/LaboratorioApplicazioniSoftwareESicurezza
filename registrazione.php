<?php
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
    window.location = "register.html";
});

                    </script>
                <?php
                }
                //Se la registrazione è corretta inserisce tutto in DB
                else {
                    $nome = $_POST['InputName'];
                    $ruolo = 'Giornalista';
                    $password =$_POST['InputPassword'];
                    $q2 = "insert into utente values ($1,$2,$3,$4)";
                    $data = pg_query_params($dbconn, $q2,
                        array($email, $nome, $password, $ruolo));
                    if ($data) {
                        ?>
                    	<!-- Messaggio di successo -->                      
                    <script >
                    Swal.fire({
  title: "<strong>La registrazione è stata effettuata correttamente</strong>",
  icon: "success",
  html: `<b>Effettua il login per iniziare ad utilizzare il sito!</b>`,
  focusConfirm: false,
  confirmButtonText: `Loggati!`
}).then(function() {
    window.location = "Loginform.php";
});

                    </script> <?php
                    }
                }
            }
        ?> 
    </body>
</html>