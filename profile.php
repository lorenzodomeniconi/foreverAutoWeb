<?php
require_once("bootstrap.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if($_SESSION["ruolo"] === Roles::BUYER->value): 
    $user = $db->getAcquirente($_SESSION["username"]);

    setTemplateParams("ForeverAuto - Il tuo profilo", 
        "templates/" . Pages::PROFILE_PAGE->value, 
        array(
            "username" => $_SESSION["username"],
            "nome" => $user["nome"],
            "cognome" => $user["cognome"],
            "email" => $user["email"] ?? null,
    ));
elseif($_SESSION["ruolo"] === Roles::DEALER->value):
    $user = $db->getConcessionaria($_SESSION["partitaIva"]);

    setTemplateParams("ForeverAuto - Il tuo profilo", 
        "templates/" . Pages::PROFILE_PAGE->value, 
        array(
            "ragSociale" => $user["ragSociale"],
            "partitaIva" => $user["partitaIva"],
            "sede" => $user["sede"] ?? null,
            "telefono" => $user["telefono"] ?? null,
            "email" => $user["email"] ?? null
    ));
endif;

require("templates/" . Pages::BASE->value);
?>