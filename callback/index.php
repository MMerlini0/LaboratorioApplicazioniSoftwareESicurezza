<?php


if (!empty($_GET['code'])) include '../_inc/requestLogIn.inc.php';
else {
    header("location:../index.php");
}
