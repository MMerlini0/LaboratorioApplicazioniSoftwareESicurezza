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

// Debug
// echo '<pre>';
// print_r($used_token_data);
// echo '</pre>';

// Store user token in Session

header("Location: $__app_url");