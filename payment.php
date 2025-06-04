<?php
require_once("bootstrap.php");

if (!isset($_SESSION["username"])) {
    header("Location: " . Pages::LOGIN->value);
    exit;
}

setTemplateParams("Pagamento", "templates/" . Pages::PAYMENT_PAGE->value);
require("templates/" . Pages::BASE->value);