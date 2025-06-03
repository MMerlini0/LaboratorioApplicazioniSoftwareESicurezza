<?php
session_start();
// Include required files
$__app_secret = "a76619b8bddd432b9248fa0be1d4ce3a";
$__app_client_id = "05a4f7e97e5f4fd9bd130d40feb97392";
$__redirect_uri ="http://localhost:3000/callback/index.php";
$__base_url="https://accounts.spotify.com";
$__app_url="http://localhost:3000/index.php";
require 'curl.class.php';

// Start new instance of CurlServer object
$__cURL = new CurlServer();

// Set URL for request to obtain the user token
$url = $__base_url . '/api/token';

// Set required Post fields to send to Spotify
$submit_post_fields = 'grant_type=authorization_code&code=' . $_GET['code'];
$submit_post_fields .= "&redirect_uri=$__redirect_uri";

// Application access token needs to be Base64 Encoded
// The content of it will be = Client ID:Client Secret
$access_token = "Basic " . base64_encode("$__app_client_id:$__app_secret");

// Start cURL Post request to obtain user tokens
$used_token_data = $__cURL->post_request($url, $submit_post_fields, $access_token);
$_SESSION['spotify_token'] = $used_token_data;



// Connessione al DB
$dbconn = pg_connect("host=localhost dbname=Untuned user=postgres password=biar port=5432");
// prendo info profilo utente
$user_info = $__cURL->get_request('https://api.spotify.com/v1/me', $used_token_data->access_token);
if (isset($user_info->display_name)) {
    $_SESSION['spotify_nome'] = $user_info->display_name;
}
if (isset($user_info->email)) {
    $_SESSION['email'] = $user_info->email;
}

//error_log('user_info->email esiste? ' . (isset($user_info->email) ? 'SI' : 'NO'));

if (isset($user_info->id)) {
    $_SESSION['spotify_id'] = $user_info->id;
}

// Recupera top 3 canzoni
$top_tracks = $__cURL->get_request('https://api.spotify.com/v1/me/top/tracks?limit=3', $used_token_data->access_token);
if (!empty($top_tracks->items)) {
    $_SESSION['canzone1'] = $top_tracks->items[0]->name ?? 'nessuna canzone';
    $_SESSION['canzone2'] = $top_tracks->items[1]->name ?? 'nessuna canzone';
    $_SESSION['canzone3'] = $top_tracks->items[2]->name ?? 'nessuna canzone';
} else {
    $_SESSION['canzone1'] = 'nessuna canzone';
    $_SESSION['canzone2'] = 'nessuna canzone';
    $_SESSION['canzone3'] = 'nessuna canzone';
}

// Recupera top 3 artisti
$top_artists = $__cURL->get_request('https://api.spotify.com/v1/me/top/artists?limit=3', $used_token_data->access_token);
if (!empty($top_artists->items)) {
    $_SESSION['artista1'] = $top_artists->items[0]->name ?? 'nessun artista';
    $_SESSION['artista2'] = $top_artists->items[1]->name ?? 'nessun artista';
    $_SESSION['artista3'] = $top_artists->items[2]->name ?? 'nessun artista';
} else {
    $_SESSION['artista1'] = 'nessun artista';
    $_SESSION['artista2'] = 'nessun artista';
    $_SESSION['artista3'] = 'nessun artista';
}


// Se utente non esiste nel DB registralo
$email = $_SESSION['email'] ?? null;
if ($email !== null) {
    $q_check = "SELECT * FROM utente WHERE email = $1";
    $result = pg_query_params($dbconn, $q_check, array($email));


    $query_utente = pg_fetch_array($result, null, PGSQL_ASSOC);
    if (!$query_utente) {
        // Utente non esiste, registra
        $nome = $_SESSION['spotify_nome'];
        $ruolo = 'Utente';
        $id = $_SESSION['spotify_id'] ?? '';
        $paswd = '';  // Nessuna password per login Spotify
        $c1 = $_SESSION['canzone1'] ?? '';
        $c2 = $_SESSION['canzone2'] ?? '';
        $c3 = $_SESSION['canzone3'] ?? '';
        $a1 = $_SESSION['artista1'] ?? '';
        $a2 = $_SESSION['artista2'] ?? '';
        $a3 = $_SESSION['artista3'] ?? '';

        $q_insert = "INSERT INTO utente VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)";
        $insert = pg_query_params($dbconn, $q_insert, array(
            $email, $nome, $paswd, $ruolo, $id,
            $c1, $c2, $c3,
            $a1, $a2, $a3
        ));

        if (!$insert) {
            error_log("Fallita registrazione utente Spotify: " . pg_last_error($dbconn));
        }
    } else {
    // Utente già registrato, aggiorna canzoni e artisti
    $c1 = $_SESSION['canzone1'] ?? '';
    $c2 = $_SESSION['canzone2'] ?? '';
    $c3 = $_SESSION['canzone3'] ?? '';
    $a1 = $_SESSION['artista1'] ?? '';
    $a2 = $_SESSION['artista2'] ?? '';
    $a3 = $_SESSION['artista3'] ?? '';

    $q_update = "UPDATE utente SET canzone1 = $1, canzone2 = $2, canzone3 = $3, artista1 = $4, artista2 = $5, artista3 = $6 WHERE email = $7";
    $update = pg_query_params($dbconn, $q_update, array(
        $c1, $c2, $c3,
        $a1, $a2, $a3,
        $email
    ));

    if (!$update) {
        error_log("Fallito aggiornamento canzoni/artisti utente Spotify: " . pg_last_error($dbconn));
    }
}
}


// Debug
// echo '<pre>';
// print_r($used_token_data);
// echo '</pre>';

// Store user token in Session


header("Location: $__app_url");

?>