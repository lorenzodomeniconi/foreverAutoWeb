<?php
require_once("bootstrap.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header("Location: " . Pages::LOGIN->value);
    exit;
}


setTemplateParams("Notifiche", "templates/" . Pages::NOTIFIES_PAGE->value, array(
        "notifiche" => $db->getNotifiesByUsername($_SESSION["username"])
    ));
require("templates/" . Pages::BASE->value);