<?php
require_once Pages::BOOTSTRAP;

setTemplateParams("ForeverAuto - Login", "templates/" . Pages::LOGIN_PAGE);

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
    header("location: " . Pages::INDEX);
    exit();
}

require 'templates/' . Pages::BASE;
?>