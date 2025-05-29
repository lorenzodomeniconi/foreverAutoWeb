<?php
require_once("bootstrap.php");

if (isset($_GET['numTelaio'])) {
    $numTelaio = $_GET['numTelaio'];

    // Recupera i dettagli del veicolo dal database
    $veicolo = $db->getVehicleByNumTelaio($numTelaio);
    
    if (!$veicolo) {
        // Se il veicolo non esiste reindirizza alla home
        header("Location: " . Pages::INDEX->value);
        exit;
    }
} else {
    // Se il numTelaio non è passato reindirizza alla home
    header("Location: " . Pages::INDEX->value);
    exit;
}

$marca = $_POST['marca'];
$modello = $_POST['modello'];
$prezzo = $_POST['prezzo'];
$descrizione = $_POST['descrizione'];
$proprietariPrecedenti = $_POST['proprietariPrecedenti'];
$kilometri = $_POST['kilometri'];
$alimentazione = $_POST['alimentazione'];
$venduto = isset($_POST['venduto']) ? 1 : 0;    

$db->updateVehicle(
    $numTelaio,
    $marca,
    $modello,
    $prezzo,
    $descrizione,
    $proprietariPrecedenti,
    $kilometri,
    $alimentazione,
    $venduto
);
header("Location: " . Pages::INDEX->value);
exit;