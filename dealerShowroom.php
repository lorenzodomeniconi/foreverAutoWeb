<?php
require_once("bootstrap.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['partitaIva'])) {
    header("Location: " . Pages::INDEX->value);
    exit;
}

$partitaIva = $_GET['partitaIva'];
$concessionaria = $db->getConcessionaria($partitaIva);
$veicoli = $db->getVehiclesByDealer($partitaIva);


setTemplateParams("Showroom - " . $concessionaria["ragSociale"], 
        "templates/" . Pages::SHOWROOM_PAGE->value, 
        array(
            "concessionaria" => $concessionaria,
            "veicoli" => $veicoli,
    ));

require("templates/" . Pages::BASE->value);
?>