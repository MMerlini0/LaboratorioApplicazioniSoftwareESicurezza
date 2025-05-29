<!DOCTYPE html>
<?php session_start();?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyRail</title>
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

<body>
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
        <main>
        <!--Diversi form per inserire i dati nel Database-->
        <table style="width:100%;">
            <tr><td>
                <div style="height: 450px;">
            <form action="code.php" method="post" style="min-width:30%;">
                            <div class="formhead">INSERISCI DATI UTENTE</div>
                <table style="margin-left: auto;margin-right: auto;">
                    <tr>
                        <p>
                            <td><label for="insertnome">Nome </label></td>
                            <td><input type="text" name="insertnome" id="insertnome" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputruolo">ruolo </label></td>
                            <td><input type="text" name="inputruolo" id="inputruolo" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputpassword">Password </label></td>
                            <td><input type="password" name="inputpassword" id="inputpassword" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputemail">Email </label></td>
                            <td><input type="email" name="inputemail" id="inputemail" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputidspotify">idspotify </label></td>
                            <td><input type="text" name="inputidspotify" id="inputidspotify" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputcanzone1">canzone 1 </label></td>
                            <td><input type="text" name="inputcanzone1" id="inputcanzone1" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputcanzone2">canzone 2 </label></td>
                            <td><input type="text" name="inputcanzone2" id="inputcanzone2" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputcanzone3">canzone 3 </label></td>
                            <td><input type="text" name="inputcanzone3" id="inputcanzone3" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputartista1">artista 1 </label></td>
                            <td><input type="text" name="inputartista1" id="inputartista1" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputartista2">artista 2 </label></td>
                            <td><input type="text" name="inputartista2" id="inputartista2" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputartista3">artista 3 </label></td>
                            <td><input type="text" name="inputartista3" id="inputartista3" required></td>
                        </p>
                    </tr>
                </table>
                <p>
                <div style="text-align: center;">
                    <input class="button" type="submit" value="Inserisci" id="inserisci">
                </div>
                <p></div>
            </form>
            </td><td height="50">
                <div style="height: 450px;">
            <form action="code.php" method="post" style="">
                <div class="formhead">INSERISCI DATI ARTICOLI</div>
                <table style="margin-left: auto;margin-right: auto;">
                    <tr>
                        <p>
                            <td><label for="insertarticoloid">Articolo ID </label></td>
                            <td><input type="number" name="insertarticoloid" id="insertarticoloid" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputtitolo">Titolo </label></td>
                            <td><input type="text" name="inputtitolo" id="inputtitolo" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputcontenuto">Contenuto </label></td>
                            <td><input type="text" name="inputcontenuto" id="inputcontenuto" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputgenere">Genere </label></td>
                            <td><input type="text" name="inputgenere" id="inputgenere" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputdatapubblicazione">Data pubblicazione </label></td>
                            <td><input type="date" name="inputdatapubblicazione" id="inputdatapubblicazione" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputemailcreatore">email creatore</label></td>
                            <td><input type="email" name="inputemailcreatore" id="inputemailcreatore" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputorariopubblicazione">Orario pubblicazione</label></td>
                            <td><input type="time" name="inputorariopubblicazione" id="inputorariopubblicazione" required></td>
                        </p>
                    </tr>
                    
                </table>
                <p>
                <div style="text-align: center;">
                    <input class="button" type="submit" value="Inserisci" id="inserisci">
                </div>
                <p></div>
            </form>
            </td></tr>
            <tr><td height="50">
                <div style="height: 450px;">
                    <br><br><br>
            <form action="code.php" method="POST" style="margin-top: 60px auto 60px auto;min-width:30%;">
                <div class="formhead">INSERSICI DATI POST</div>
                <table style="margin-left: auto;margin-right: auto;">
                    <tr>
                        <p>
                            <td><label for="insertid">Post ID </label></td>
                            <td><input type="number" name="insertid" id="insertid" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputtitolo">Titolo </label></td>
                            <td><input type="text" name="inputtitolo" id="inputtitolo" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputcontenuto">Contenuto </label></td>
                            <td><input type="text" name="inputcontenuto" id="inputcontenuto" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputgenere">Genere </label></td>
                            <td><input type="text" name="inputgenere" id="inputgenere" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputdatapubblicazione">Data pubblicazione </label></td>
                            <td><input type="date" name="inputdatapubblicazione" id="inputdatapubblicazione" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputemailcreatore">email creatore</label></td>
                            <td><input type="email" name="inputemailcreatore" id="inputemailcreatore" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputorariopubblicazione">Orario pubblicazione</label></td>
                            <td><input type="time" name="inputorariopubblicazione" id="inputorariopubblicazione" required></td>
                        </p>
                    </tr>
                    
                </table>
                <p>
                <div style="text-align: center;">
                    <input class="button" type="submit" value="Inserisci" id="inserisci">
                </div>
                <p></div>
            </form>
            </td><td>
                <div style="height: 450px;">
            <form action="code.php" method="POST" style="float:top;min-width:30%;">
                        <div class="formhead">INSERISCI DATI COMMENTI</div>
                        <table style="margin-left: auto;margin-right: auto;">
                        <tr>
                        <p>
                            <td><label for="insercommentotid">Commento ID </label></td>
                            <td><input type="number" name="insercommentotid" id="insercommentotid" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="insertpostid">Post ID </label></td>
                            <td><input type="number" name="insertpostid" id="insertpostid" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="insertarticoloid">Articolo ID </label></td>
                            <td><input type="number" name="insertarticoloid" id="insertarticoloid" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputemailcreatore">email creatore</label></td>
                            <td><input type="email" name="inputemailcreatore" id="inputemailcreatore" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputcontenuto">Contenuto </label></td>
                            <td><input type="text" name="inputcontenuto" id="inputcontenuto" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputgenere">Genere </label></td>
                            <td><input type="text" name="inputgenere" id="inputgenere" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputorariopubblicazione">Orario Commento</label></td>
                            <td><input type="time" name="inputorariopubblicazione" id="inputorariopubblicazione" required></td>
                        </p>
                    </tr>
                    <tr>
                        <p>
                            <td><label for="inputdatapubblicazione">Data Commento </label></td>
                            <td><input type="date" name="inputdatapubblicazione" id="inputdatapubblicazione" required></td>
                        </p>
                    </tr>
                    
                </table>
                        <p>
                        <div style="text-align: center;">
                            <input class="button" type="submit" value="Inserisci" id="inserisci">
                        </div>
                        <p></div>
                    </form>
                    </td></tr>
                    </table>
        </main>
    </body>
</html>