<?php
require_once("bootstrap.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
$db->insertVehicle(
    $_POST['numTelaio'],
    $_POST['marca'],
    $_POST['modello'],
    $_POST['descrizione'],
    $_POST['alimentazione'],
    $_POST['prezzo'],
    $_POST['tipo'],
    $_SESSION['partitaIva'],
    $_POST['kilometri'],
    $_POST['proprietariPrecedenti']
);
header("Location: " . Pages::INDEX->value);
exit;