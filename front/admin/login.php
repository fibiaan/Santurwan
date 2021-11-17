<?php

session_start();
$_SESSION['logged'] = True;
if (isset($_SESSION['logged']) && $_SESSION['logged']) {
    header('Location: admin/admin.php');
}