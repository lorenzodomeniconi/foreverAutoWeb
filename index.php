<?php
require_once("bootstrap.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setTemplateParams("ForeverAuto - Home", "templates/" . Pages::HOME_PAGE->value, array(
    "vehicles" => $db->getVehicles(), 
    "categories" => $db->getCategories()
));

$search = isset($_GET['search']) ? $_GET['search'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$disponibilita = isset($_GET['disponibilita']) ? $_GET['disponibilita'] : '';

if(isUserLoggedIn()) {
    // Visualizzazione concessionaria //
    if(isset($_SESSION['ragSociale'])) { 
        setTemplateParams("ForeverAuto - Home", "templates/" . Pages::DEALER_PAGE->value, array(
            "vehicles" => $db->getVehiclesByDealer($_SESSION['partitaIva'])
        ));
    }
    // Visualizzazione cliente //
    else {
        // Creo un carrello per l'utente
        $_SESSION['codCarrello'] = $db->getOrCreateCarrello($_SESSION['username']);

        setTemplateParams("ForeverAuto - Home", "templates/" . Pages::HOME_PAGE->value, array(
            "vehicles" => $db->getVehicles($search, $categoria, $disponibilita),
            "categories" => $db->getCategories()
        ));
    }

// Utente non loggato, creazione carrello non necessaria //
} else {
    setTemplateParams("ForeverAuto - Home", "templates/" . Pages::HOME_PAGE->value, array(
        "vehicles" => $db->getVehicles($search, $categoria, $disponibilita),
        "categories" => $db->getCategories()
    ));
}

require "templates/" . Pages::BASE->value;
?>