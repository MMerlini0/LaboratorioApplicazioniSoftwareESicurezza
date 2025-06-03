<?php


if (!empty($_GET['code'])) include '../_inc/requestLogIn.inc.php';
else {
    echo '<pre>';
    print_r($_GET);
    echo '</pre>';
}
