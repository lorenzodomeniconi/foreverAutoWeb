<?php 
require_once("bootstrap.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$categories = $db->getCategories();
//var_dump($templateParams['categorie']);

setTemplateParams("Inserimento Nuovo Veicolo", "templates/" . Pages::ADD_VEHICLE->value, array(
    "categories" => $categories
));

require "templates/" . Pages::BASE->value;
