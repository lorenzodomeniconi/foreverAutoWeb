<?php
require_once("bootstrap.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Controlla se il numTelaio è passato come parametro GET
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

setTemplateParams("Modifica Veicolo", "templates/" . Pages::UPDATE_VEHICLE->value, array(
        "vehicle" => $veicolo
    ));
require("templates/" . Pages::BASE->value);