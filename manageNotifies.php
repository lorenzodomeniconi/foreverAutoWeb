<?php
require_once("bootstrap.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header("Location: " . Pages::LOGIN->value);
    exit;
}
if (isset($_POST['elimina'])) {
    $codNotifica = $_POST['codNotifica'];
    $db->deleteNotify($codNotifica);
} elseif (isset($_POST['segnaLetta'])) {
    $codNotifica = $_POST['codNotifica'];
    $db->markNotifyAsRead($codNotifica);
}

header('Location: ' . Pages::NOTIFIES->value);
?>