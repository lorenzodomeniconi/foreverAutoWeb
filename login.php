<?php
require_once "bootstrap.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

setTemplateParams("ForeverAuto - Login", "templates/" . Pages::LOGIN_PAGE->value);

// Controlla se l'utente ha già effettuato il login
if(isset($_POST['username']) && isset($_POST['password'])) {
    $result = $db->getUtenteByCredenziali($_POST['username'], $_POST['password']);
    
    if($result != null) {
        // Login andato a buon fine e salvataggio in sessione
        $templateParams["message"] = "Accesso effettuato";
        if($result['role'] == Roles::BUYER) {
            registerUser($result, false);
        } else {
            registerUser($result, true);
        }
    } else {
        $templateParams["error"] = "Errore in fase di login: controllare le credenziali.";
        $templateParams["errType"] = ErrorTypes::LOGIN;
    }
}

// Controlla se i dati sono salvati nella sessione e in caso reindirizzo alla pagina home
if(isUserLoggedIn()) {
    header("location: " . Pages::INDEX->value);
    exit();
}

require 'templates/' . Pages::BASE->value;
?>