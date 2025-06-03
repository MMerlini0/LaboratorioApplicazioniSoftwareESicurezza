<!DOCTYPE html>
<?php
session_start();
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");

$__app_secret    = "a76619b8bddd432b9248fa0be1d4ce3a";
$__app_client_id = "05a4f7e97e5f4fd9bd130d40feb97392";
$__redirect_uri  = "http://localhost:3000/callback/index.php";
$__base_url      = "https://accounts.spotify.com";
$__app_url       = "http://localhost:3000/index.php";
require '_inc/curl.class.php';

// Solo admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: LoginAdmin.php');
    exit;
}

/*************************************************
 * QUERY DATI ARTICOLI con filtri   &   ricerca  *
 *************************************************/
$search        = $_GET['search']           ?? null;            // stringa di ricerca titolo
$genereFiltro  = $_POST['inputgenerefiltro'] ?? null;           // select del filtro genere

$params = [];
$sql    = "SELECT * FROM articolo WHERE ban = 'false'";

// filtro genere
if ($genereFiltro !== null) {
    $sql     .= " AND genere = $1";
    $params[] = $genereFiltro;
}

// search titolo (case‑insensitive LIKE)
if ($search !== null) {
    $idx      = count($params) + 1;                 // posizione del bind
    $sql     .= " AND LOWER(titolo) LIKE LOWER('%' || $$idx || '%')";
    $params[] = $search;
}

$sql .= " ORDER BY datapubblicazione DESC";

$result = pg_query_params($dbconn, $sql, $params);
$check  = pg_num_rows($result);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untuned – Articoli (Admin)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="stile.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap">
    <link rel="icon" href="pictures/LogoEasyRail.jpg" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="script.js" defer></script>
    <style>
        main {
            background:url(pictures/back3.jpg) space;
            background-size:cover;
            background-position:top;
        }
    </style>
</head>
<body>
<header class="topnav">
    <nav>
        <a class="titolo" href="index.php">Untuned</a>
        <div class="log dropdown"><button class="dropbtn">Admin</button></div>
        <a class="center" href="Admin.php">Area Admin</a>
        <a href="logout.php" style="margin-right:1%">Logout</a>
    </nav>
</header>
<br>

<!-- FILTRI -->
<div class="form-2" style="width:auto;margin-left: auto;margin-right: auto;">
    <form class="d-flex align-items-center gap-3 flex-wrap" action="articoliadmin.php" method="POST" style="margin-top:-15px">
        <label class="m-0" for="inputgenerefiltro"><h4 class="m-0">Genere</h4></label>
        <select name="inputgenerefiltro" id="inputgenerefiltro" style="width:150px;height:40px;font-size:16px" required>
            <option value="genere1" <?= $genereFiltro==='genere1'?'selected':'';?>>Pop</option>
            <option value="genere2" <?= $genereFiltro==='genere2'?'selected':'';?>>Hip Hop / Rap</option>
            <option value="genere3" <?= $genereFiltro==='genere3'?'selected':'';?>>Rock</option>
            <option value="genere4" <?= $genereFiltro==='genere4'?'selected':'';?>>EDM</option>
            <option value="genere5" <?= $genereFiltro==='genere5'?'selected':'';?>>Reggaeton / Latin</option>
        </select>
        <button class="btn btn-danger" type="submit">Applica</button>
    </form>
    <div class="mt-3">
        <form action="articoliadmin.php" method="GET" class="input-group mb-3">
            <input type="text" name="search" value="<?= htmlspecialchars($search ?? '',ENT_QUOTES,'UTF-8'); ?>" class="form-control" placeholder="Search titolo" required>
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div>
</div>

<!-- LISTA ARTICOLI -->
<div class="form-2" style="width:auto;margin:0 auto 30px auto;">
    <h1 class="text-center text-black">ARTICOLI</h1>

    <?php if ($check > 0): ?>
        <?php while ($row = pg_fetch_array($result)): ?>
            <div class="post-card" onclick="location.href='visualizzazionearticolo.php?ARTICOLOID=<?= $row['articoloid']; ?>';">
                <div class="post-title"><?= htmlspecialchars($row['titolo'],ENT_QUOTES,'UTF-8'); ?></div>

                <div class="post-body"><?= nl2br(htmlspecialchars($row['contenuto'],ENT_QUOTES,'UTF-8')); ?></div>

                <div class="post-footer">
                    <div class="post-meta">
                        <span class="genre"><?= htmlspecialchars($row['genere'],ENT_QUOTES,'UTF-8'); ?></span>
                        <span class="genre">ID: <?= $row['articoloid']; ?></span>
                        <span class="date"><?= htmlspecialchars($row['datapubblicazione'],ENT_QUOTES,'UTF-8'); ?></span>
                        <span class="email"><?= htmlspecialchars($row['emailcreatore'],ENT_QUOTES,'UTF-8'); ?></span>
                    </div>
                    <div class="post-actions">
                        <form action="code.php" method="POST" style="display:inline">
                            <input type="hidden" name="deletearticoloid" value="<?= $row['articoloid']; ?>">
                            <button class="btn btn-danger" type="submit">Cancella dati</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center">Nessun articolo disponibile</p>
    <?php endif; ?>
</div>

<main>
<footer>
    <table>
        <tr>
            <td>
                <p>Untuned &copy;</p>
                <p>Un progetto per Laboratorio di Architetture Software e Sicurezza Informatica – A.A. 2023/24 – Prof. Daniele Cono D'Elia, Prof. Leonardo Querzoni</p>
            </td>
        </tr>
        <tr>
            <td>Capitale Sociale 0&euro;. Fondatori: Merlini &amp; DiCarlo &amp; Scolamiero<br>Tutti i diritti riservati.</td>
            <td>Sede legale Università La Sapienza – Edificio Marco Polo, Viale Scalo San Lorenzo, 82, Roma</td>
        </tr>
    </table>
</footer>
</main>
</body>
</html>