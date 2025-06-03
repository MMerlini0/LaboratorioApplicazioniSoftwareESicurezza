<?php
session_start();
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");

$email    = $_POST['InputEmail']    ?? null;
$password = $_POST['InputPassword'] ?? null;

if (!$email || !$password) {
    header('Location: LoginAdmin.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
if ($dbconn) {
    $email = $_POST['InputEmail'] ?? '';
    $password = $_POST['InputPassword'] ?? '';

    // Controllo se esiste utente con questa email, password e ruolo 'Admin'
    $q = "SELECT * FROM utente WHERE email = $1 AND paswd = $2 AND ruolo = 'Admin'";
    $result = pg_query_params($dbconn, $q, array($email, $password));
    $tuple = pg_fetch_array($result, null, PGSQL_ASSOC);

    if ($tuple) {
        // Autenticazione admin riuscita
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $tuple['nome'];
        $_SESSION['ruolo'] = 'Admin';
        $_SESSION['is_admin'] = true;
        header("Location: Admin.php");
        exit;
    } else {
        // Credenziali non valide o non admin
        ?>
        <script>
        Swal.fire({
            title: "Accesso negato",
            icon: "error",
            html: "<b>Email o password errati, o non sei un Admin.</b>",
            confirmButtonText: "Riprova"
        }).then(() => {
            window.location = "LoginAdmin.php";
        });
        </script>
        <?php
    }
}
?>
</body>
</html>
