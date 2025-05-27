<?php 
require_once(Pages::BOOTSTRAP);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$categories = $db->getCategorie();
//var_dump($templateParams['categorie']);

setTemplateParams("Inserimento Nuovo Veicolo", "templates/" . Pages::ADD_VEHICLE, array(
    "categories" => $categories
));

require "templates/" . Pages::BASE;
