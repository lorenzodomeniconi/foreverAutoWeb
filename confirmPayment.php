<?php
require_once("bootstrap.php");

if (!isset($_SESSION["username"])) {
    header("Location: " . Pages::LOGIN->value);
    exit;
}

$username = $_SESSION["username"];
$codCarrello = $_SESSION['codCarrello'];

if ($codCarrello !== null) {
    $db->closeCartAndPay($codCarrello);
}
setTemplateParams("Pagamento Confermato", "templates/" . Pages::CONFIRMED_PAYMENT->value);
require "templates/" . Pages::BASE->value;