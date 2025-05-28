<?php
require_once("bootstrap.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);

if(isset($_POST["codFiscale"])) {
    // Registrazione utente
    if($db->createNewUtente($_POST, "acquirente")) {
        // Registra le informazioni in sessione
        registerUser($_POST, false);
        header("location: " . Pages::INDEX->value);
        exit();
    } else {
        $templateParams["erroresignup"] = "Errore nella registrazione";
    }
} else if(isset($_POST["partitaIva"])) {
    // Registrazione concessionaria
    if($db->createNewUtente($_POST, "concessionaria")) {
        // Registra le informazioni in sessione
        registerUser($_POST, true);
        header("location: " . Pages::INDEX->value);
        exit();
    } else {
        $templateParams["erroresignup"] = "Errore nella registrazione";
    }
    header("location: " . Pages::INDEX->value);
    exit();
}

setTemplateParams("ForeverAuto - Registrazione", "templates/" . Pages::SIGNUP_PAGE->value);

require 'templates/' . Pages::BASE->value;
?>