<?php
require_once("bootstrap.php");

if (!isset($_SESSION['username'])) {
    // Se l'utente non è loggato, redirect alla pagina di login
    header("Location: " . Pages::INDEX->value);
    exit;
}

if (isset($_POST['telaio'])) {
    $numTelaio = $_POST['telaio'];
    $username = $_SESSION['username'];
    $codCarrello = $_SESSION['codCarrello'];

    $res = $db->insertVehicleInCart($codCarrello, $numTelaio);
    if ($res == '') {
        // Successo: reindirizza alla pagina del carrello
        header("Location: " . Pages::CART->value);
        exit;
    } else {
        $_SESSION['erroreCarrello'] = "Errore nell'aggiungere il veicolo al carrello." . $res;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        }
} else {
    header("Location: " . Pages::INDEX->value);
    exit;
}
?>