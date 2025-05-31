<?php
require_once("bootstrap.php");

if (!isset($_SESSION["username"])) {
    header("Location: " . Pages::LOGIN->value);
    exit;
}

if (isset($_POST["numTelaio"])) {
    $numTelaio = $_POST["numTelaio"];
    $username = $_SESSION["username"];
    $codCarrello = $_SESSION['codCarrello'];

    if ($codCarrello !== null) {
        $db->deleteVehicleFromCart($codCarrello, $numTelaio);
    }
}

header("Location: " . Pages::CART->value);
exit;