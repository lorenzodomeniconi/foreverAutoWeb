<?php

enum Roles: string {
    case BUYER = 'acquirente';
    case DEALER = 'concessionaria';
}

enum Pages: string {
    case BOOTSTRAP = 'bootstrap.php';
    case BASE = 'base.php';
    case INDEX = 'index.php';
    case HOME = 'home.php';
    case LOGIN = 'login.php';
    case PROFILE = 'profile.php';
    // case SETTINGS = 'settings.php';
    
    case HOME_PAGE = 'homePage.php';
    case LOGIN_PAGE = 'loginForm.php';
    case DEALER_PAGE = 'dealerPage.php';
    case ADD_VEHICLE = 'addVehicleForm.php';
}

enum ErrorTypes: int {
    case NOT_FOUND = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 402;
    case SERVER_ERROR = 403;
    case BAD_REQUEST = 404;

    case LOGIN = 100;
}

// Check se l'utente ha già effettuato l'accesso
function isUserLoggedIn() {
    return isset($_SESSION['username']);
}

// Salvataggio in sessione del nome, tipo e notifiche dell'utente
function registerUser($user, $dealer, $notifiche = null) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['dealer'] = $dealer;
    if($dealer) {
        $_SESSION['ragSociale'] = $user['ragSociale'];
    } else {
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['cognome'] = $user['cognome'];
    }
    $_SESSION['notfiche'] = isset($_SESSION['notfiche']) ? $_SESSION['notfiche'] : array();
}

// Log-out dell'utente (destroy della sessione corrente)
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
    if(basename($_SERVER['PHP_SELF']) == $pagename){
        echo " class='active' ";
    }
}

// Set dei parametri obj template
function setTemplateParams($title, $pageName, $params = array()) {
    $templateParams['title'] = $title;
    $templateParams['name'] = $pageName;
    foreach($params as $key => $value) {
        $templateParams[$key] = $value;
    }
    return $templateParams;
}

?>