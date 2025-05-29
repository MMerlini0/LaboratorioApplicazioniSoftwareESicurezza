<!DOCTYPE html>
<?php session_start();
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");
?>
<html lang="en">

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
            <div class="table-responsive-lg" style="width:100%;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Nome</th>
                            <th>Ruolo</th>
                            <th>Password</th>
                            <th>Modifica</th>
                            <th>Cancella</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                    $query="SELECT * FROM utente";
                    $result=pg_query($query);
                    //Controllo se la query ha dato dei valori

                    $check=pg_num_rows($result);
                    if($check >0){
                    while($row = pg_fetch_array($result))
                    {?>
                        <tr>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['ruolo']; ?></td>
                            <td><?php echo  $row['paswd']; ?></td>
                            <td><form style="margin-top: -15px;">
                                <a href="edit.php?email=<?php echo $row['email']; ?>" class="btn btn-success">Modifica dati</a>
                    </form></td>
                            <td> 
                                <?php if( $row['email'] != 'admin@admin.it'){ ?>
                                <form style="margin-top: -15px;" action="code.php" method="POST">
                                    <input type="hidden" name=deleteemail value="<?php echo $row['email']; ?>">
                                    <button type="submit" class="btn btn-danger">Cancella dati</button>
                                </form>
                               <?php }else{ ?>
                                <form style="margin-top: -15px;" action="" method="POST">
                                <input type="hidden" name=deleteemail value="<?php echo $row['email']; ?>">
                                <button type="submit" class="btn btn-danger" disabled>Cancella dati</button>
                            </form> <?Php
                               } ?>
                            </td>
                        </tr><?php
                    }}else{ ?>
                    <td>NULL</td>
                    <td>NULL</td>
                    <td>NULL</td>
                    <td>NULL</td>
                    <td>NULL</td>  
                    <td>NULL</td>  
                    <?php } ?>
                  </tbody> 
                </table>
            </div>
        </body>
    </main>
</html>