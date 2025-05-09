<?php

// check se l'utente ha già effettuato l'accesso
function isUserLoggedIn() {
    return isset($_SESSION['username']);
}

// salvataggio in sessione del nome, tipo e notifiche dell'utente
function registerUser($user, $dealer, $notifiche) {
    $_SESSION['username'] = $user['username'];
    if($dealer) {
        $_SESSION['dealer'] = true;
        $_SESSION['ragSociale'] = $user['ragSociale'];
    } else {
        $_SESSION['dealer'] = false;
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['cognome'] = $user['cognome'];
    }
    $_SESSION['notfiche'] = $notifiche;
}

// log-out dell'utente distruggendo la sessione corrente
function logOut() {
    $_SESSION['username'] = NULL;
    $_SESSION['nome'] = NULL;
    $_SESSION['cognome'] = NULL;
    $_SESSION['notifiche'] = NULL;
    $_SESSION['dealer'] = NULL;
    $_SESSION['ragSociale'] = NULL;
    session_destroy();
}

function isActive($pagename){
    if(basename($_SERVER['PHP_SELF'])==$pagename){
        echo " class='active' ";
    }
}

?>