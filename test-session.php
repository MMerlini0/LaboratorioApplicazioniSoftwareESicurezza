<?php
session_start();

$_SESSION['spotify_token'] = (object)[
    'access_token' => 'otko7e11nljj2q8exnbguedxm'
];
$_SESSION['spotify_nome'] = 'Weresky';
$_SESSION['email'] = 'weresky1@gmail.com';

header('Location: profilo.php');
exit;