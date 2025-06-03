<?php session_start();
//Connessione DB
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");
// Vedo se nella sessione non sono admin e se il token da admin è settato e sta a true, (lo setto a false)
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) { // Non sono admin
    if(isset($_POST['creato_da_admin']) && $_POST['creato_da_admin'] === 'true') { // E qualcuno prova a spacciarsene
        $_POST['creato_da_admin'] = 'false'; // Tolgo il token
    }
}



//Controlli su diversi valori inviati da un form della fase di inserimento nella pagina insert.php
if(isset($_POST['insertnome']))
{
    $email=$_POST['inputemail'];
    $nome=$_POST['insertnome'];
    $ruolo=$_POST['inputruolo'];
    $paswd=$_POST['inputpassword'];
    $id=$_POST['inputidspotify'];
    $canzone1=$_POST['inputcanzone1'];
    $canzone2=$_POST['inputcanzone2'];
    $canzone3=$_POST['inputcanzone3'];
    $artista1=$_POST['inputartista1'];
    $artista2=$_POST['inputartista2'];
    $artista3=$_POST['inputartista3'];

    $q2 = "INSERT into utente values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)";
    $data = pg_query_params($dbconn, $q2,
    array($email, $nome, $paswd, $ruolo, $id, $canzone1 ,$canzone2,$canzone3,$artista1,$artista2,$artista3));
    header('location: admin.php');
}


// Creazione di un post
if(isset($_POST['tokenPost']) && $_POST['tokenPost'] === 'true')
{
    //CREA POST ADMIN
    if (isset($_POST['creato_da_admin']) && $_POST['creato_da_admin'] === "true") {
        $titolo = $_POST['inputtitolo'];
        $contenuto = $_POST['inputcontenuto'];
        $genere = $_POST['inputgenere'];
        $datapubblicazione = $_POST['inputdatapubblicazione'];
        $orariopubblicazione = $_POST['inputorariopubblicazione'];
        $emailcreatore = $_POST['inputemailcreatore'];

        $q1 = "INSERT INTO post (titolo, contenuto, genere, datapubblicazione, orariopubblicazione, emailcreatore)
            VALUES ($1, $2, $3, $4, $5, $6)";
        $data = pg_query_params($dbconn, $q1, array(
            $titolo, $contenuto, $genere, $datapubblicazione, $orariopubblicazione, $emailcreatore
        ));

        if (!$data) {
            error_log("Errore nella query post admin: " . pg_last_error($dbconn));
            exit("Errore nella creazione del post.");
        }

        header('Location: Admin.php');
        exit;
    } else { 
        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];
        $datapubblicazione=$_POST['inputdatapubblicazione'];
        $orariopubblicazione=$_POST['inputorariopubblicazione'];
        $emailcreatore=$_POST['inputemailcreatore'];

        $q1 = "INSERT INTO post (titolo, contenuto, genere, datapubblicazione, orariopubblicazione, emailcreatore)
                VALUES ($1, $2, $3, $4, $5, $6)";
        $data = pg_query_params($dbconn, $q1,
            array($titolo, $contenuto, $genere, $datapubblicazione, $orariopubblicazione, $emailcreatore));
        if (!$data) {
            error_log("Errore nella query: " . pg_last_error($dbconn));
            exit;
        }
        header('location: index.php');
        exit;
    }
}

// Creazione di un commento
if (isset($_POST['tokenCommento']) && $_POST['tokenCommento'] === 'true') {
    $postid          = $_POST['inpututentepostid'];
    $articoloid      = null; 
    $utenteemail     = $_POST['inputemailcreatore'];
    $contenuto       = $_POST['inputcontenuto'];
    $orariocommento  = $_POST['inputorariopubblicazione'];
    $datacommento    = $_POST['inputdatapubblicazione'];

    $q1 = "INSERT INTO commenti (postid, articoloid, utenteemail, contenuto, orariocommento, datacommento)
            VALUES ($1, $2, $3, $4, $5, $6)";

    $res = pg_query_params($dbconn, $q1, [
        $postid, $articoloid, $utenteemail, $contenuto, $orariocommento, $datacommento
    ]);

    if ($res) {
        header('Location: index.php');
    } else {
        error_log("Errore inserimento commento: " . pg_last_error($dbconn));
        echo "<script>alert('Errore nell\'inserimento del commento.'); window.location.href = 'index.php';</script>";
    }
    exit;
}

if(isset($_POST['tokenCommentoArticolo']) && $_POST['tokenCommentoArticolo'] === 'true')
{
    $postid = NULL;
    $articoloid=$_POST['inpututentearticoloid'];
    $utenteemail=$_POST['inputemailcreatore'];
    $contenuto=$_POST['inputcontenuto'];
    $orariocommento=$_POST['inputorariopubblicazione'];
    $datacommento=$_POST['inputdatapubblicazione'];


    $q1 = "INSERT into commenti (postid, articoloid, utenteemail, contenuto, orariocommento, datacommento)
                values ($1,$2,$3,$4,$5,$6)";
    $data = pg_query_params($dbconn, $q1,
        array($postid,$articoloid,$utenteemail,$contenuto,$orariocommento,$datacommento));
    if ($data) {
        header('Location: index.php');
    } else {
        error_log("Errore inserimento commento: " . pg_last_error($dbconn));
        echo "<script>alert('Errore nell\'inserimento del commento.'); window.location.href = 'index.php';</script>";
    }
    exit;
}


// Creazione di un articolo
if(isset($_POST['tokenArticolo']) && $_POST['tokenArticolo'] === 'true') {
    
    //CREA ARTICOLO ADMIN
    if (isset($_POST['creato_da_admin']) && $_POST['creato_da_admin'] === "true") {
        $titolo = $_POST['inputtitolo'];
        $contenuto = $_POST['inputcontenuto'];
        $genere = $_POST['inputgenere'];
        $datapubblicazione = $_POST['inputdatapubblicazione'];
        $orariopubblicazione = $_POST['inputorariopubblicazione'];
        $emailcreatore = $_POST['inputemailcreatore'];

        $q1 = "INSERT INTO articolo (titolo, contenuto, genere, datapubblicazione, orariopubblicazione, emailcreatore)
            VALUES ($1, $2, $3, $4, $5, $6)";
        $data = pg_query_params($dbconn, $q1, array(
            $titolo, $contenuto, $genere, $datapubblicazione, $orariopubblicazione, $emailcreatore
        ));

        header('Location: Admin.php');
        exit;
    } else { // Creato da giornalista

        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];
        $datapubblicazione=$_POST['inputdatapubblicazione'];
        $orariopubblicazione=$_POST['inputorariopubblicazione'];
        $emailcreatore=$_POST['inputemailcreatore'];
        

        $q1 = "INSERT INTO articolo (titolo, contenuto, genere, datapubblicazione, orariopubblicazione, emailcreatore)
            VALUES ($1, $2, $3, $4, $5, $6)";
        $data = pg_query_params($dbconn, $q1, array(
            $titolo, $contenuto, $genere, $datapubblicazione, $orariopubblicazione, $emailcreatore
        ));
        header('location: index.php'); 
    }
}
    
    


    if(isset($_POST['insertgiornalistaarticoloid']))
    {
        $articoloid=$_POST['insertgiornalistaarticoloid'];
        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];
        $datapubblicazione=$_POST['inputdatapubblicazione'];
        $orariopubblicazione=$_POST['inputorariopubblicazione'];
        $emailcreatore=$_POST['inputemailcreatore'];
        


        $q1 = "INSERT into articolo values ($1,$2,$3,$4,$5,$6,$7)";
        $data = pg_query_params($dbconn, $q1,
        array($articoloid, $titolo,$contenuto,$genere,$datapubblicazione,$orariopubblicazione,$emailcreatore));
        header('location: articoli.php'); 
    }


//Controlli su diversi valori inviati da un form della fase di modifica dati nella pagina edit.php
    if(isset($_POST['updateemail']))
    {
        $email=$_POST['updateemail'];
        $nome=$_POST['inputnome'];
        $ruolo=$_POST['inputruolo'];
        $password=$_POST['inputpassword'];

        $query = "UPDATE utente SET email='$email', nome='$nome', ruolo='$ruolo', paswd='$password'  WHERE email='$email'";
        $data = pg_query($dbconn,$query);
        header('location: shutente.php');
    }
    if(isset($_POST['inputcontenutocommento']))
    {
        $commentiid=$_POST['idcommento'];
        $contenuto=$_POST['inputcontenutocommento'];

        $query = "UPDATE commenti SET contenuto='$contenuto' WHERE commentiid='$commentiid'";
        $data = pg_query($dbconn,$query);
        header('location: shcommenti.php');

    }
    if(isset($_POST['updatecontenutocommento']))
    {
        $contenuto=$_POST['updatecontenutocommento'];
        $commentoid=$_POST['idcommentoupdate'];

        $query = "UPDATE commenti SET contenuto='$contenuto' WHERE commentiid='$commentoid'";
        $data = pg_query($dbconn,$query);
        header('location: index.php');
    }
    if(isset($_POST['updatecontenutocommentoarticolo']))
    {
        $contenuto=$_POST['updatecontenutocommentoarticolo'];
        $commentoid=$_POST['idcommentoupdate'];

        $query = "UPDATE commenti SET contenuto='$contenuto' WHERE commentiid='$commentoid'";
        $data = pg_query($dbconn,$query);
        header('location: articoli.php');
    }

    if(isset($_POST['updatepostid']))
    {
        $postid=$_POST['updatepostid'];
        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];
        $datapubblicazione=$_POST['inputdatapubblicazione'];
        $orariopubblicazione=$_POST['inputorariopubblicazione'];
        $emailcreatore=$_POST['inputemailcreatore'];

        $query = "UPDATE post SET postid='$postid', titolo='$titolo', contenuto='$contenuto',
        genere='$genere',orariopubblicazione='$orariopubblicazione', datapubblicazione='$datapubblicazione'
        WHERE postid='$postid'";
        pg_query($dbconn,$query);
        header('location: indeadmin.php');
    }

    if(isset($_POST['updateutentepostid']))
    {
        $postid=$_POST['updateutentepostid'];
        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];
        $query = "UPDATE post SET titolo='$titolo', contenuto='$contenuto',
        genere='$genere'
        WHERE postid='$postid'";
        pg_query($dbconn,$query);
        header('location: index.php');
    }

    if(isset($_POST['updatearticoloid']))
    {
        $articoloid=$_POST['updatearticoloid'];
        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];
        $datapubblicazione=$_POST['inputdatapubblicazione'];
        $orariopubblicazione=$_POST['inputorariopubblicazione'];
        $emailcreatore=$_POST['inputemailcreatore'];

        $query = "UPDATE articolo SET articoloid='$articoloid', titolo='$titolo', contenuto='$contenuto',
        genere='$genere',orariopubblicazione='$orariopubblicazione', datapubblicazione='$datapubblicazione'
        WHERE articoloid='$articoloid'";
        pg_query($dbconn,$query);
        header('location: sharticolo.php');
    }

    if(isset($_POST['updateutentearticoloid']))
    {
        $articoloid=$_POST['updateutentearticoloid'];
        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];

        $query = "UPDATE articolo SET titolo='$titolo', contenuto='$contenuto',
        genere='$genere'
        WHERE articoloid='$articoloid'";
        pg_query($dbconn,$query);
        header('location: articoli.php');
    }


//Controlli su diversi valori inviati da un form quando viene cliccato il bottone per la cancellazione dei dati
    if(isset($_POST['deleteemail'])){
        $email=$_POST['deleteemail'];
        $query="DELETE FROM utente WHERE email='$email'";
        $result=pg_query($dbconn,$query);
        header('location: shutente.php');
    }
    if(isset($_POST['deletecommento'])){
        $commentiid=$_POST['deletecommento'];
        $query="DELETE FROM commenti WHERE commentiid='$commentiid'";
        $result=pg_query($dbconn,$query);
        header('location: shcommenti.php');
    }

    if(isset($_POST['deleteid'])){
        $postid=$_POST['deleteid'];
        $query="DELETE FROM post WHERE postid='$postid'";
        $result=pg_query($dbconn,$query);
        header('location: indexadmin.php');
    }
    if(isset($_POST['utentedeleteid'])){
        $postid=$_POST['utentedeleteid'];
        $query="DELETE FROM post WHERE postid='$postid'";
        $result=pg_query($dbconn,$query);
        header('location: index.php');
    }
    if(isset($_POST['utentedeleteidcommento'])){
        $postid=$_POST['utentedeleteidcommento'];
        $query="DELETE FROM commenti WHERE commentiid='$postid'";
        $result=pg_query($dbconn,$query);
        header('location: index.php');
    }
    

    if(isset($_POST['deletearticoloid'])){
        $articoloid=$_POST['deletearticoloid'];
        $query="DELETE FROM articolo WHERE articoloid='$articoloid'";
        $result=pg_query($dbconn,$query);
        header('location: articoliadmin.php');
    }
    if(isset($_POST['giornalistadeleteid'])){
        $articoloid=$_POST['giornalistadeleteid'];
        $query="DELETE FROM articolo WHERE articoloid='$articoloid'";
        $result=pg_query($dbconn,$query);
        header('location: articoli.php');
    }

    if(isset($_POST['deletecodbiglietto'])){
        $codbiglietto=$_POST['deletecodbiglietto'];
        $email=$_POST['email'];
        $query="DELETE FROM prenotazione WHERE codbiglietto='$codbiglietto' and email='$email'";
        $result=pg_query($dbconn,$query);
        header('location: shprenotazioni.php');
    }

    if(isset($_POST['deletecodbiglietto2'])){
        $codbiglietto=$_POST['deletecodbiglietto2'];
        $email=$_POST['email'];
        $query="DELETE FROM prenotazione WHERE codbiglietto='$codbiglietto' and email='$email'";
        $result=pg_query($dbconn,$query);
        header('location: profilo.php');
    }


//UPGRADE UTENTE ADMIN
if(isset($_POST['inputidutente'])) {
    $idutente = $_POST['inputidutente'];
    $ruolocorrente = $_POST['inputruolocorrente'];
    $nuovoruolo = $_POST['inputnuovoruolo'];

    // Verifica se l'utente con nome e ruolo corrente esiste
    $q_check = "SELECT * FROM utente WHERE nome = $1 AND ruolo = $2";
    $result = pg_query_params($dbconn, $q_check, array($idutente, $ruolocorrente));

    if (pg_num_rows($result) === 0) {
        // se utente non trovato mostra alert
        error_log("Nome utente e/o ruolo non esistenti nel database");
        header('Location: Admin.php');
        exit;
    }

    // Utente esiste, aggiorna ruolo
    $query = "UPDATE utente SET ruolo = $1 WHERE nome = $2 AND ruolo = $3";
    $data = pg_query_params($dbconn, $query, array($nuovoruolo, $idutente, $ruolocorrente));

    if ($data) {
        error_log("Upgrade riuscito");
        header('Location: Admin.php');
        exit;
    } else {
        error_log("Errore nell\'aggiornamento del ruolo.");
        header('Location: Admin.php');
        exit;
    }
    header('Location: Admin.php');
}



//DELETE RICHIESTA
if (isset($_POST['richiestericevute'])) {                       // se non l’hai già fatto prima
    $email  = $_POST['richiestericevute'];

    // query parametrica = niente injection
    $sql    = "DELETE FROM richieste WHERE email = $1";
    $res    = pg_query_params($dbconn, $sql, [$email]);

    $ok = $res && pg_affected_rows($res) > 0;

    /* ---------- PAGINA‐PONTE ------------- */
    ?>
    <!DOCTYPE html><html lang="it"><head>
        <meta charset="UTF-8">
        <title>Redirect…</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <style>body{margin:0;background:#f5f5f5;}</style>
    </head><body>
        <script>
        Swal.fire({
            icon: <?= $ok ? "'success'" : "'error'" ?>,
            title: <?= $ok
                        ? "'Richiesta eliminata'"
                        : "'Errore durante l\\'eliminazione'" ?>,
            showConfirmButton: false,
            timer: 1800
        }).then(() => window.location.href = 'Admin.php');
        </script>
    </body></html>
    <?php
    exit;
}



//BAN-SBAN
if(isset($_POST['idpostban']))
{
    $idpost=$_POST['idpostban'];
    $query = "UPDATE utente SET banpost = 'false' WHERE email = $1";
    $res   = pg_query_params($dbconn, $query, [$idpost]);
    $ok = $res && pg_affected_rows($res) > 0;
    ?>
    <!DOCTYPE html><html lang="it"><head>
        <meta charset="UTF-8">
        <title>Redirect…</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <style>body{margin:0;background:#f5f5f5;}</style>
    </head><body>
        <script>
        Swal.fire({
            icon: <?= $ok ? "'success'" : "'error'" ?>,
            title: <?= $ok
                    ? "'Ban eseguito'"
                    : "'Errore durante l eliminazione'" ?>,
            showConfirmButton: false,
            timer: 1800
        }).then(() => window.location.href = 'Admin.php');
        </script>
    </body></html>
    <?php
    exit;
}
if (isset($_POST['idpostsban'])) {
    $idpost = $_POST['idpostsban'];
    $query = "UPDATE utente SET banpost = 'false' WHERE email = $1";
    $res = pg_query_params($dbconn, $query, [$idpost]);
    $ok = $res && pg_affected_rows($res) > 0;
    ?>
    <!DOCTYPE html><html lang="it"><head>
    <meta charset="UTF-8">
    <title>Redirect…</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>body{margin:0;background:#f5f5f5;}</style>
    </head><body>
    <script>
    Swal.fire({
        icon: <?= $ok ? "'success'" : "'error'" ?>,
        title: <?= $ok ? "'SBAN dai post eseguito'" : "'Errore: mail non trovata'" ?>,
        showConfirmButton: false,
        timer: 1800
    }).then(() => window.location.href = 'Admin.php');
    </script>
    </body></html>
    <?php exit;
}
if (isset($_POST['idarticoloban'])) {
    $idpost = $_POST['idarticoloban'];
    $query = "UPDATE utente SET banarticoli = 'true' WHERE email = $1";
    $res = pg_query_params($dbconn, $query, [$idpost]);
    $ok = $res && pg_affected_rows($res) > 0;
    ?>
    <!DOCTYPE html><html lang="it"><head>
    <meta charset="UTF-8">
    <title>Redirect…</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>body{margin:0;background:#f5f5f5;}</style>
    </head><body>
    <script>
    Swal.fire({
        icon: <?= $ok ? "'success'" : "'error'" ?>,
        title: <?= $ok ? "'BAN dagli articoli eseguito'" : "'Errore: mail non trovata'" ?>,
        showConfirmButton: false,
        timer: 1800
    }).then(() => window.location.href = 'Admin.php');
    </script>
    </body></html>
    <?php exit;
}
if (isset($_POST['idarticolosban'])) {
    $idpost = $_POST['idarticolosban'];
    $query = "UPDATE utente SET banarticoli = 'false' WHERE email = $1";
    $res = pg_query_params($dbconn, $query, [$idpost]);
    $ok = $res && pg_affected_rows($res) > 0;
    ?>
    <!DOCTYPE html><html lang="it"><head>
    <meta charset="UTF-8">
    <title>Redirect…</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>body{margin:0;background:#f5f5f5;}</style>
    </head><body>
    <script>
    Swal.fire({
        icon: <?= $ok ? "'success'" : "'error'" ?>,
        title: <?= $ok ? "'SBAN dagli articoli eseguito'" : "'Errore: mail non trovata'" ?>,
        showConfirmButton: false,
        timer: 1800
    }).then(() => window.location.href = 'Admin.php');
    </script>
    </body></html>
    <?php exit;
}
if (isset($_POST['idcommentoban'])) {
    $idpost = $_POST['idcommentoban'];
    $query = "UPDATE utente SET bancommenti = 'true' WHERE email = $1";
    $res = pg_query_params($dbconn, $query, [$idpost]);
    $ok = $res && pg_affected_rows($res) > 0;
    ?>
    <!DOCTYPE html><html lang="it"><head>
    <meta charset="UTF-8">
    <title>Redirect…</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>body{margin:0;background:#f5f5f5;}</style>
    </head><body>
    <script>
    Swal.fire({
        icon: <?= $ok ? "'success'" : "'error'" ?>,
        title: <?= $ok ? "'BAN dai commenti eseguito'" : "'Errore: mail non trovata'" ?>,
        showConfirmButton: false,
        timer: 1800
    }).then(() => window.location.href = 'Admin.php');
    </script>
    </body></html>
    <?php exit;
}
if (isset($_POST['idcommentosban'])) {
    $idpost = $_POST['idcommentosban'];
    $query = "UPDATE utente SET bancommenti = 'false' WHERE email = $1";
    $res = pg_query_params($dbconn, $query, [$idpost]);
    $ok = $res && pg_affected_rows($res) > 0;
    ?>
    <!DOCTYPE html><html lang="it"><head>
    <meta charset="UTF-8">
    <title>Redirect…</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>body{margin:0;background:#f5f5f5;}</style>
    </head><body>
    <script>
    Swal.fire({
        icon: <?= $ok ? "'success'" : "'error'" ?>,
        title: <?= $ok ? "'SBAN dai commenti eseguito'" : "'Errore: mail non trovata'" ?>,
        showConfirmButton: false,
        timer: 1800
    }).then(() => window.location.href = 'Admin.php');
    </script>
    </body></html>
    <?php exit;
}
if (isset($_POST['idutenteban'])) {
    $idpost = $_POST['idutenteban'];
    $query = "UPDATE utente SET ban = 'true' WHERE email = $1";
    $res = pg_query_params($dbconn, $query, [$idpost]);
    $ok = $res && pg_affected_rows($res) > 0;
    ?>
    <!DOCTYPE html><html lang="it"><head>
    <meta charset="UTF-8">
    <title>Redirect…</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>body{margin:0;background:#f5f5f5;}</style>
    </head><body>
    <script>
    Swal.fire({
        icon: <?= $ok ? "'success'" : "'error'" ?>,
        title: <?= $ok ? "'Utente bannato con successo'" : "'Errore: mail non trovata'" ?>,
        showConfirmButton: false,
        timer: 1800
    }).then(() => window.location.href = 'Admin.php');
    </script>
    </body></html>
    <?php exit;
}
if (isset($_POST['idutentesban'])) {
    $idpost = $_POST['idutentesban'];
    $query = "UPDATE utente SET ban = 'false' WHERE email = $1";
    $res = pg_query_params($dbconn, $query, [$idpost]);
    $ok = $res && pg_affected_rows($res) > 0;
    ?>
    <!DOCTYPE html><html lang="it"><head>
    <meta charset="UTF-8">
    <title>Redirect…</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>body{margin:0;background:#f5f5f5;}</style>
    </head><body>
    <script>
    Swal.fire({
        icon: <?= $ok ? "'success'" : "'error'" ?>,
        title: <?= $ok ? "'Utente sbannato con successo'" : "'Errore: mail non trovata'" ?>,
        showConfirmButton: false,
        timer: 1800
    }).then(() => window.location.href = 'Admin.php');
    </script>
    </body></html>
    <?php exit;
}





// RICHIESTA GIORNALISTA
if (isset($_POST['tokenRichiesta']) && $_POST['tokenRichiesta'] === 'true') {

    $emailRichiedente = $_POST['inputemailcreatore'] ?? '';
    $contenuto = $_POST['inputcontenuto']      ?? '';

    // evita doppioni lato server
    $check = pg_query_params($dbconn,
        "SELECT 1 FROM richieste WHERE email = $1 LIMIT 1", [$emailRichiedente]);

    if (pg_num_rows($check) === 0) {
        pg_query_params($dbconn,
            "INSERT INTO richieste (email, referenze) VALUES ($1, $2)",
            [$emailRichiedente, $contenuto]);
    }

    header('Location: profilo.php');
    exit;
}


?>