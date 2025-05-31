<?php
require_once("bootstrap.php");

if (!isset($_SESSION['username'])) {
    header("Location: " . Pages::LOGIN->value);
    exit;
}

$username = $_SESSION['username'];

// Ottiene il carrello aperto dell'utente salvato in sessione
$carrello = $_SESSION['codCarrello'];
if (!$carrello) {
    // Se l'utente non ha un carrello aperto, mostra un messaggio di errore
    echo "Non hai un carrello aperto.";
    exit;
}

$veicoliCarrello = $db->getVehicleInCart($carrello);

// Rimuove i veicoli venduti
foreach ($veicoliCarrello as $veicolo) {
    if ($veicolo['venduto']) {
        // Rimuovi il veicolo dal carrello se è stato venduto
        $db->deleteVehicleFromCart($carrello, $veicolo['numTelaio']);
    }
}

// Ottieni i veicoli aggiornati nel carrello (senza quelli venduti)
$veicoliCarrelloAggiornati = $db->getVehicleInCart($carrello);
setTemplateParams("Carrello", "templates/" . Pages::CART_PAGE->value, array(
        "vehicles" => $veicoliCarrelloAggiornati
    ));

require "templates/" . Pages::BASE->value;
?>