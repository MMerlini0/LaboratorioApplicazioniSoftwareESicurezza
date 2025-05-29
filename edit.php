<!DOCTYPE html>
<?php session_start();
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");
?><html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyRail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="stile.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap">
    <link rel="icon" href="pictures/LogoEasyRail.jpg" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <style>
    input {
        margin: 0;
        width: 240px;
    }
    </style>
</head>
<main>
    <!--Barra superiore-->
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

    <body>

        <?php
        //Controllo con diversi IF che sia richiesta la modifica di un dato database attraverso una variabile(UTENTE)
        if(isset($_GET['email'])){ ?>
            <DIV style="width:100%">
            <div class="table-responsive-lg" style="width:100%;">
                <?php        
                    $email=$_GET['email'];
                    $query="SELECT * FROM utente WHERE email='$email'";
                    $result=pg_query($dbconn,$query);
                    while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
                    {?>
                <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;">
                    <div class="formhead">MODIFICA DATI UTENTE</div>
                    <table style="margin-left: auto;margin-right: auto;">
                        <tr>
                            <p>
                                <td><label for="inputnome">Nome </label></td>
                                <td><input type="text" name="inputnome" value="<?php echo $row['nome'];?>" id="inputnome"
                                        required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="inputruolo">Ruolo </label></td>
                                <td><input type="text" name="inputruolo" value="<?php echo $row['ruolo'];?>"
                                        id="inputruolo" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="inputpassword">Password </label></td>
                                <td><input type="text" name="inputpassword" value="<?php echo $row['paswd'];?>"
                                        id="inputpassword" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="updateemail">Email </label></td>
                                <td><input type="email" name="updateemail" value="<?php echo $row['email'];?>"
                                        id="updateemail" readonly></td>
                            </p>
                        </tr>
                    </table>
                    <p>
                    <div style="text-align: center;">
                        <input class="button" type="submit" value="Modifica" id="inserisci">
                    </div>
                    <p>
                </form>
                <?php
                    }}
                    ?>
            </div>
        </div>
        <?php 
                //Controllo con diversi IF che sia richiesta la modifica di un dato database attraverso una variabile(VIAGGI)
        if(isset($_GET['postid'])){ ?>
            <DIV style="width:100%">
            <div class="card-body">
                <?php        
                    $postid=$_GET['postid'];
                    $query="SELECT * FROM post WHERE postid='$postid'";
                    $result=pg_query($dbconn,$query);
                    while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
                    {?>
                <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;">
                    <div class="formhead">MODIFICA DATI POST</div>
                    <table style="margin-left: auto;margin-right: auto;">
                        <tr>
                            <p>
                                <td><label for="codice">Post ID </label></td>
                                <td><input type="text" name="updatepostid" value="<?php echo $row['postid'];?>"
                                        id="nome" readonly></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="titolo">titolo </label></td>
                                <td><input type="text" name="inputtitolo" value="<?php echo $row['titolo'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="contenuto">contenuto </label></td>
                                <td><input type="text" name="inputcontenuto" value="<?php echo $row['contenuto'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="genere">genere</label></td>
                                <td><input type="text" name="inputgenere" value="<?php echo $row['genere'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label hidden for="datapubblicazione">data pubblicazione</label></td>
                                <td><input type="hidden" name="inputdatapubblicazione" value="<?php echo $row['datapubblicazione'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label hidden for="orariopubblicazione">orario pubblicazione</label></td>
                                <td><input type="hidden" name="inputorariopubblicazione" id="economy" value="<?php echo $row['orariopubblicazione'];?>" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label hidden for="emailcreatore">email creatore</label></td>
                                <td><input  type="hidden" name="inputemailcreatore" id="prima" value="<?php echo $row['emailcreatore'];?>" required></td>
                            </p>
                        </tr>
                    </table>
                    <p>
                    <div style="text-align: center;">
                        <input class="button" type="submit" value="Modifica" id="inserisci">
                    </div>
                    <p>
                </form>
                <?php
                    }}
                    ?>
            </div>
        </div>
        <?php 
        if(isset($_GET['utentepostidcommento'])){ ?>
            <DIV style="width:100%">
            <div class="card-body">
                <?php        
                    $commentiid=$_GET['utentepostidcommento'];
                    $query="SELECT * FROM commenti WHERE commentiid='$commentiid'";
                    $result=pg_query($dbconn,$query);
                    while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
                    {?>
                <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;">
                    <div class="formhead">MODIFICA DATI COMMENTO</div>
                    <table style="margin-left: auto;margin-right: auto;">
                        <tr>
                            <p> 
                            <td><input type="text" name="idcommentoupdate" value="<?php echo $commentiid;?>"
                            id="idcommentoupdate" readonly hidden></td>
                                <td><label for="updatecontenutocommento">contenuto </label></td>
                                <td><input type="text" name="updatecontenutocommento" value="<?php echo $row['contenuto'];?>"
                                        id="updatecontenutocommento" required></td>
                            </p>
                        </tr>
                    </table>
                    <p>
                    <div style="text-align: center;">
                        <input class="button" type="submit" value="Modifica" id="inserisci">
                    </div>
                    <p>
                </form>
                <?php
                    }}
                    ?>
                    <?php 
        if(isset($_GET['utentearticoloidcommento'])){ ?>
            <DIV style="width:100%">
            <div class="card-body">
                <?php        
                    $commentiid=$_GET['utentearticoloidcommento'];
                    $query="SELECT * FROM commenti WHERE commentiid='$commentiid'";
                    $result=pg_query($dbconn,$query);
                    while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
                    {?>
                <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;">
                    <div class="formhead">MODIFICA DATI COMMENTO</div>
                    <table style="margin-left: auto;margin-right: auto;">
                        <tr>
                            <p> 
                            <td><input type="text" name="idcommentoupdate" value="<?php echo $commentiid;?>"
                            id="idcommentoupdate" readonly hidden></td>
                                <td><label for="updatecontenutocommento">contenuto </label></td>
                                <td><input type="text" name="updatecontenutocommentoarticolo" value="<?php echo $row['contenuto'];?>"
                                        id="updatecontenutocommento" required></td>
                            </p>
                        </tr>
                    </table>
                    <p>
                    <div style="text-align: center;">
                        <input class="button" type="submit" value="Modifica" id="inserisci">
                    </div>
                    <p>
                </form>
                <?php
                    }}
                    ?>
            </div>
            <?php 
        if(isset($_GET['commentiid'])){ ?>
            <DIV style="width:100%">
            <div class="card-body">
                <?php        
                    $commentiid=$_GET['commentiid'];
                    $query="SELECT * FROM commenti WHERE commentiid='$commentiid'";
                    $result=pg_query($dbconn,$query);
                    while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
                    {?>
                <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;">
                    <div class="formhead">MODIFICA DATI COMMENTO</div>
                    <table style="margin-left: auto;margin-right: auto;">
                    <input type="hidden" name=idcommento value="<?php echo $commentiid ?>">
                        <tr>
                            <p>
                                <td><label for="inputcontenutocommento">contenuto </label></td>
                                <td><input type="text" name="inputcontenutocommento" value="<?php echo $row['contenuto'];?>"
                                        id="inputcontenutocommento" required></td>
                            </p>
                        </tr>
                    </table>
                    <p>
                    <div style="text-align: center;">
                        <input class="button" type="submit" value="Modifica" id="inserisci">
                    </div>
                    <p>
                </form>
                <?php
                    }}
                    ?>
            </div>
        <?php 
        if(isset($_GET['utentepostid'])){ ?>
            <DIV style="width:100%">
            <div class="card-body">
                <?php        
                    $postid=$_GET['utentepostid'];
                    $query="SELECT * FROM post WHERE postid='$postid'";
                    $result=pg_query($dbconn,$query);
                    while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
                    {?>
                <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;">
                    <div class="formhead">MODIFICA DATI POST</div>
                    <table style="margin-left: auto;margin-right: auto;">
                        <tr>
                            <p>
                                <input type="hidden" name=updateutentepostid value="<?php echo $postid; ?>">
                                <td><label for="titolo">titolo </label></td>
                                <td><input type="text" name="inputtitolo" value="<?php echo $row['titolo'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="contenuto">contenuto </label></td>
                                <td><input type="text" name="inputcontenuto" value="<?php echo $row['contenuto'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="genere">genere</label></td>
                                <td><input type="text" name="inputgenere" value="<?php echo $row['genere'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                    </table>
                    <p>
                    <div style="text-align: center;">
                        <input class="button" type="submit" value="Modifica" id="inserisci">
                    </div>
                    <p>
                </form>
                <?php
                    }}
                    ?>
                    <?php 
        if(isset($_GET['utentearticoloid'])){ ?>
            <DIV style="width:100%">
            <div class="card-body">
                <?php        
                    $articoloid=$_GET['utentearticoloid'];
                    $query="SELECT * FROM articolo WHERE articoloid='$articoloid'";
                    $result=pg_query($dbconn,$query);
                    while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
                    {?>
                <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;">
                    <div class="formhead">MODIFICA DATI POST</div>
                    <table style="margin-left: auto;margin-right: auto;">
                        <tr>
                            <p>
                                <input type="hidden" name=updateutentearticoloid value="<?php echo $postid; ?>">
                                <td><label for="titolo">titolo </label></td>
                                <td><input type="text" name="inputtitolo" value="<?php echo $row['titolo'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="contenuto">contenuto </label></td>
                                <td><input type="text" name="inputcontenuto" value="<?php echo $row['contenuto'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="genere">genere</label></td>
                                <td><input type="text" name="inputgenere" value="<?php echo $row['genere'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                    </table>
                    <p>
                    <div style="text-align: center;">
                        <input class="button" type="submit" value="Modifica" id="inserisci">
                    </div>
                    <p>
                </form>
                <?php
                    }}
                    ?>
            </div>
        </div> <?php
                //Controllo con diversi IF che sia richiesta la modifica di un dato database attraverso una variabile(TRENI)
                if(isset($_GET['articoloid'])){ ?>
                    <DIV style="width:100%">
                    <div class="card-body">
                        <?php        
                            $articoloid=$_GET['articoloid'];
                            $query="SELECT * FROM articolo WHERE articoloid='$articoloid'";
                            $result=pg_query($dbconn,$query);
                            while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
                            {?>
                        <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;">
                            <div class="formhead">MODIFICA DATI ARTICOLO</div>
                            <table style="margin-left: auto;margin-right: auto;">
                                <tr>
                                    <p>
                                        <td><label for="codice">Articolo ID </label></td>
                                        <td><input type="text" name="updatearticoloid" value="<?php echo $row['articoloid'];?>"
                                                id="nome" readonly></td>
                                    </p>
                                </tr>
                                <tr>
                                    <p>
                                        <td><label for="titolo">titolo </label></td>
                                        <td><input type="text" name="inputtitolo" value="<?php echo $row['titolo'];?>"
                                                id="nome" required></td>
                                    </p>
                                </tr>
                                <tr>
                                    <p>
                                        <td><label for="contenuto">contenuto </label></td>
                                        <td><input type="text" name="inputcontenuto" value="<?php echo $row['contenuto'];?>"
                                                id="nome" required></td>
                                    </p>
                                </tr>
                                <tr>
                                    <p>
                                        <td><label for="genere">genere</label></td>
                                        <td><input type="text" name="inputgenere" value="<?php echo $row['genere'];?>"
                                                id="nome" required></td>
                                    </p>
                                </tr>
                                <tr>
                                    <p>
                                        <td><label hidden for="datapubblicazione">data pubblicazione</label></td>
                                        <td><input type="hidden" name="inputdatapubblicazione" value="<?php echo $row['datapubblicazione'];?>"
                                                id="nome" required></td>
                                    </p>
                                </tr>
                                <tr>
                                    <p>
                                        <td><label hidden for="orariopubblicazione">orario pubblicazione</label></td>
                                        <td><input type="hidden" name="inputorariopubblicazione" id="economy" value="<?php echo $row['orariopubblicazione'];?>" required></td>
                                    </p>
                                </tr>
                                <tr>
                                    <p>
                                        <td><label hidden for="emailcreatore">email creatore</label></td>
                                        <td><input type="hidden" name="inputemailcreatore" id="prima" value="<?php echo $row['emailcreatore'];?>" required></td>
                                    </p>
                                </tr>
                            </table>
                            <p>
                            <div style="text-align: center;">
                                <input class="button" type="submit" value="Modifica" id="inserisci">
                            </div>
                            <p>
                        </form>
                        <?php
                            }}
                            ?>
                    </div>
                </div> <?php
                if(isset($_GET['giornalistaarticoloid'])){ ?>
                    <DIV style="width:100%">
                    <div class="card-body">
                        <?php        
                            $articoloid=$_GET['giornalistaarticoloid'];
                            $query="SELECT * FROM articolo WHERE articoloid='$articoloid'";
                            $result=pg_query($dbconn,$query);
                            while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
                            {?>
                        <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;">
                            <div class="formhead">MODIFICA DATI ARTICOLO</div>
                            <table style="margin-left: auto;margin-right: auto;">
                                <tr>
                                    <p>
                                    <input type="hidden" name=updategiornalistaarticoloid value="<?php echo $articoloid; ?>">
                                        <td><label for="titolo">titolo </label></td>
                                        <td><input type="text" name="inputtitolo" value="<?php echo $row['titolo'];?>"
                                                id="nome" required></td>
                                    </p>
                                </tr>
                                <tr>
                                    <p>
                                        <td><label for="contenuto">contenuto </label></td>
                                        <td><input type="text" name="inputcontenuto" value="<?php echo $row['contenuto'];?>"
                                                id="nome" required></td>
                                    </p>
                                </tr>
                                <tr>
                                    <p>
                                        <td><label for="genere">genere</label></td>
                                        <td><input type="text" name="inputgenere" value="<?php echo $row['genere'];?>"
                                                id="nome" required></td>
                                    </p>
                                </tr>
                            </table>
                            <p>
                            <div style="text-align: center;">
                                <input class="button" type="submit" value="Modifica" id="inserisci">
                            </div>
                            <p>
                        </form>
                        <?php
                            }}
                            ?>
                    </div>
                </div>
        <?php 
        
        //Controllo con diversi IF che sia richiesta la modifica di un dato database attraverso una variabile(PRENOTAZIONI)
        if(isset($_GET['codbiglietto'])){ ?>
        <DIV style="width:100%">
            <div class="card-body">
                <?php        
                    $codbiglietto=$_GET['codbiglietto'];
                    $query="SELECT * FROM prenotazione WHERE codbiglietto='$codbiglietto'";
                    $result=pg_query($dbconn,$query);
                    while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
                    {?>
                <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;">
                    <div class="formhead">MODIFICA DATI PRENOTAZIONI</div>
                    <table style="margin-left: auto;margin-right: auto;">
                        <tr>
                            <p>
                                <td><label for="codice">Codice </label></td>
                                <td><input type="text" name="inputcodice3" value="<?php echo $row['codice'];?>"
                                        id="codice" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="email">Email </label></td>
                                <td><input type="email" name="inputemail2" value="<?php echo $row['email'];?>"
                                        id="email" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="codbiglietto">Codice Biglietto </label></td>
                                <td><input type="number" name="updatecodbiglietto"
                                        value="<?php echo $row['codbiglietto'];?>" id="codbiglietto" disabled></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="hpartenza">Orario Partenza</label></td>
                                <td><input type="time" name="inputhpartenza" value="<?php echo $row['hpartenza'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                        <tr>
                            <p>
                                <td><label for="harrivo">Orario Arrivo</label></td>
                                <td><input type="time" name="inputharrivo" value="<?php echo $row['harrivo'];?>"
                                        id="nome" required></td>
                            </p>
                        </tr>
                        <tr>
                        <p>
                            <td><label for="datapartenza">Data Partenza</label></td>
                            <td><input type="date" name="inputdatapartenza" value="<?php echo $row['datapartenza']; ?>" id=datapartenza required></td>
                        </p>
                    </tr>
                    </table>
                    <p>
                    <div style="text-align: center;">
                        <input class="button" type="submit" value="Modifica" id="inserisci">
                    </div>
                    <p>
                </form>
                <?php
                    }}
                    ?>
            </div>
        </div>
    </body>
</main>

</html>