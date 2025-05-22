<?php
require_once(Pages::BOOTSTRAP);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setTemplateParams("ForeverAuto - Home", "templates/" . Pages::HOME_PAGE, array(
    "vehicles" => "", // TODO: recuperare i veicoli dal database
    "categories" => "" // TODO: recuperare le categorie dal database
));

if(isUserLoggedIn()) {
    // Visualizzazione concessionaria 
    if(isset($_SESSION['ragSociale'])) { //
        $vehicles = $db->getVeicoliByConcessionaria($_SESSION['partitaIva']);
        setTemplateParams("ForeverAuto - Home", "templates/" . Pages::DEALER_PAGE, array(
            "vehicles" => $vehicles
        ));
    }
    // Visualizzazione cliente //
    else { 
        // Lista veicoli con filtri applicati 
        $vehicles = $db->getVeicoli($search, $categoria, $disponibilita);
        $categories = $db->getCategorie();

        // Creo un carrello per l'utente
        $_SESSION['codCarrello'] = $db->getOrCreateCarrello($_SESSION['username']);

        setTemplateParams("ForeverAuto - Home", "templates/" . Pages::HOME_PAGE, array(
            "vehicles" => $vehicles,
            "categories" => $categories
        ));
    }

// Utente non loggato, creazione carrello non necessaria //
} else {
    $vehicles = $db->getVeicoli($search, $categoria, $disponibilita);
    $categories = $db->getCategorie();

    setTemplateParams("ForeverAuto - Home", "templates/" . Pages::HOME_PAGE, array(
        "vehicles" => $vehicles,
        "categories" => $categories
    ));
}

require "templates/" . Pages::BASE;
?>