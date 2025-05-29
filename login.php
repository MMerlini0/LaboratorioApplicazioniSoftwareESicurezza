<?php
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Accedi</title>
    <link href="stile.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="pictures/LogoEasyRail.jpg" type="image/x-icon">
</head>
    <body>
        <?php
        session_start();
        //Controlla se la connessione con il database è attiva 
            if ($dbconn) {
                //effettua controllo se una data email si trova nel database utente
                $email = $_POST['InputEmail'];
                $_SESSION['email'] = $email;
                $q1 = "select * from utente where email= $1";
                $result = pg_query_params($dbconn, $q1, array($email));
                if (!($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                    ?>
                    	<!-- Messaggio di errore -->
                    <script >
                    Swal.fire({
  title: "<strong>Errore nell'accesso</strong>",
  icon: "error",
  html: `<b>Non sembra che ti sia registrato</b>`,
  focusConfirm: false,
  confirmButtonText: `Registrati!`
}).then(function() {
    window.location = "Register.html";
});

                    </script> <?php                }
                else {
                    //effettua controllo se una data password sia correlata a una data email
                    $password =$_POST['InputPassword'];
                    $q2 = "select * from utente where email = $1 and paswd = $2";
                    $result = pg_query_params($dbconn, $q2, array($email,$password));
                    if (!($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                        ?>
                    <script >
                    Swal.fire({
  title: "<strong>Errore nell'accesso</strong>",
  icon: "error",
  html: `<b>La password e' sbagliata!</b>`,
  focusConfirm: false,
  confirmButtonText:'Riprova!'
  
}).then(function() {
    window.location = "Login.html";
});;

                    </script> <?php                     }
                    else {
                        //Inizializzo le variabili globali dell'utente corrente
                        $nome = $tuple['nome'];
                        $_SESSION['name']=$nome;
                        $email= $tuple['email'];
                        $_SESSION['email']=$_POST['InputEmail'];;
                        $ruolo= $tuple['ruolo'];
                        $_SESSION['ruolo']=$ruolo;
                        header("location:index.php");
                    }
                }
            }
        ?> 
    </body>
</html>