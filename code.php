<?php session_start();
//Connessione DB
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");

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

    if(isset($_POST['insertid']))
    {
        $postid=$_POST['insertid'];
        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];
        $datapubblicazione=$_POST['inputdatapubblicazione'];
        $orariopubblicazione=$_POST['inputorariopubblicazione'];
        $emailcreatore=$_POST['inputemailcreatore'];
        


        $q1 = "INSERT into post values ($1,$2,$3,$4,$5,$6,$7)";
        $data = pg_query_params($dbconn, $q1,
            array($postid, $titolo,$contenuto,$genere,$datapubblicazione,$emailcreatore,$orariopubblicazione));
            header('location: admin.php');
    }
    if(isset($_POST['insertutentepostid']))
    {
        $postid=$_POST['insertutentepostid'];
        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];
        $datapubblicazione=$_POST['inputdatapubblicazione'];
        $orariopubblicazione=$_POST['inputorariopubblicazione'];
        $emailcreatore=$_POST['inputemailcreatore'];
        


        $q1 = "INSERT into post values ($1,$2,$3,$4,$5,$6,$7)";
        $data = pg_query_params($dbconn, $q1,
            array($postid, $titolo,$contenuto,$genere,$datapubblicazione,$orariopubblicazione,$emailcreatore));
            header('location: index.php');
    }
    if(isset($_POST['insertutentecommentoidpost']))
    {
        $commentiid=$_POST['insertutentecommentoidpost'];
        $postid=$_POST['inpututentepostid'];
        $articoloid=NULL;
        $utenteemail=$_POST['inputemailcreatore'];
        $contenuto=$_POST['inputcontenuto'];
        $orariocommento=$_POST['inputorariopubblicazione'];
        $datacommento=$_POST['inputdatapubblicazione'];


        $q1 = "INSERT into commenti values ($1,$2,$3,$4,$5,$6,$7)";
        $data = pg_query_params($dbconn, $q1,
            array($commentiid, $postid,$articoloid,$utenteemail,$contenuto,$orariocommento,$datacommento));
            header('location: index.php');
        }
        if(isset($_POST['insertutentecommentoidarticolo']))
        {
            $commentiid=$_POST['insertutentecommentoidarticolo'];
            $postid=NULL;
            $articoloid=$_POST['inpututentearticoloid'];
            $utenteemail=$_POST['inputemailcreatore'];
            $contenuto=$_POST['inputcontenuto'];
            $orariocommento=$_POST['inputorariopubblicazione'];
            $datacommento=$_POST['inputdatapubblicazione'];
    
    
            $q1 = "INSERT into commenti values ($1,$2,$3,$4,$5,$6,$7)";
            $data = pg_query_params($dbconn, $q1,
                array($commentiid, $postid,$articoloid,$utenteemail,$contenuto,$orariocommento,$datacommento));
                header('location: articoli.php');
            }
    if(isset($_POST['insertarticoloid']))
    {
        $articoloid=$_POST['insertarticoloid'];
        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];
        $datapubblicazione=$_POST['inputdatapubblicazione'];
        $orariopubblicazione=$_POST['inputorariopubblicazione'];
        $emailcreatore=$_POST['inputemailcreatore'];
        


        $q1 = "INSERT into articolo values ($1,$2,$3,$4,$5,$6,$7)";
        $data = pg_query_params($dbconn, $q1,
        array($articoloid, $titolo,$contenuto,$genere,$datapubblicazione,$emailcreatore,$orariopubblicazione));
        header('location: admin.php'); 
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
    if(isset($_POST['inputcodice3']))
    {
        $codice=$_POST['inputcodice3'];
        $f0=$_POST['inputfermata0'];
        $f1=$_POST['inputfermata1'];
        $f2=$_POST['inputfermata2'];
        $f3=$_POST['inputfermata3'];
        $f4=$_POST['inputfermata4'];
        $f5=$_POST['inputfermata5'];
        $hf0=$_POST['inputhfermata0'];
        $hf1=$_POST['inputhfermata1'];
        $hf2=$_POST['inputhfermata2'];
        $hf3=$_POST['inputhfermata3'];
        $hf4=$_POST['inputhfermata4'];
        $hf5=$_POST['inputhfermata5'];
        


        $q4 = "insert into trenocompleto values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13)";
        $data = pg_query_params($dbconn, $q4,
            array($codice,$f0,$f1,$f2,$f3,$f4,$f5,$hf0,$hf1,$hf2,$hf3,$hf4,$hf5));
            header('location: admin.php');
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
        header('location: shpost.php');
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

    if(isset($_POST['updategiornalistaarticoloid']))
    {
        $articoloid=$_POST['updategiornalistaarticoloid'];
        $titolo=$_POST['inputtitolo'];
        $contenuto=$_POST['inputcontenuto'];
        $genere=$_POST['inputgenere'];

        $query = "UPDATE articolo SET titolo='$titolo', contenuto='$contenuto',
        genere='$genere'
        WHERE articoloid='$articoloid'";
        pg_query($dbconn,$query);
        header('location: articoli.php');
    }

    if(isset($_POST['updatecodbiglietto']))
    {
        $codice=$_POST['inputcodice3'];
        $email=$_POST['inputemail2'];
        $codbiglietto=$_POST['updatecodbiglietto'];
        $orariopart=$_POST['inputhpartenza'];
        $orarioarr=$_POST['inputharrivo'];
        $datapartenza=$POST['inputdatapartenza'];

        $query = "UPDATE prenotazione SET codice='$codice', email='$email', codbiglietto='$codbiglietto',hpartenza='$orariopart' , harrivo ='$orarioarr', datapartenza='$datapartenza' WHERE codbiglietto='$codbiglietto' and email='$email'";
        $data = pg_query($dbconn,$query);
        header('location: shprenotazioni.php');
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
        header('location: shpost.php');
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
        header('location: sharticolo.php');
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
?>