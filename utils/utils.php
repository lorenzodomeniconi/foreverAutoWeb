<?php

enum Roles: string {
    case BUYER = 'acquirente';
    case DEALER = 'concessionaria';
}

enum Pages: string {
    case BOOTSTRAP = 'bootstrap.php';
    case UTILS = 'utils.php';
    case BASE = 'base.php';
    case INDEX = 'index.php';
    case HOME = 'home.php';
    case LOGIN = 'login.php';
    case PROFILE = 'profile.php';
    // case SETTINGS = 'settings.php';
    case NOTIFIES = 'notifies.php';
    
    case HOME_PAGE = 'homePage.php';
    case LOGIN_PAGE = 'loginForm.php';
    case DEALER_PAGE = 'dealerPage.php';
    case ADD_VEHICLE = 'addVehicleForm.php';
    case SIGNUP_PAGE = 'signupForm.php';
    case SINGLE_VEHICLE = 'singleVehicle.php';
    case UPDATE_VEHICLE = 'updateVehicleForm.php';
    case PROFILE_PAGE = 'profilePage.php';
    case CART = 'cart.php';
    case CART_PAGE = 'cartPage.php';
    case SHOWROOM_PAGE = 'showroom.php';
    case PAYMENT_PAGE = 'paymentForm.php';
    case NOTIFIES_PAGE = 'notifiesPage.php';
    case CONFIRMED_PAYMENT = 'confirmedPayment.php';
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
function registerUser($user, $concessionaria, $notifiche = null) {
    $_SESSION['username'] = $user['username'];
    if($concessionaria) {
        $_SESSION['ruolo'] = "concessionaria";
        $_SESSION['ragSociale'] = $user['ragSociale'];
        $_SESSION['partitaIva'] = $user['partitaIva'];
    } else {
        $_SESSION['nome'] = $user['nome'] . " " . $user['cognome'];
        $_SESSION['ruolo'] = "acquirente";
    }
    $_SESSION['notifiche'] = isset($_SESSION['notifiche']) ? $_SESSION['notifiche'] : array();
}

// Log-out dell'utente (destroy della sessione corrente)
function logOut() {
    $_SESSION['username'] = NULL;
    $_SESSION['nome'] = NULL;
    $_SESSION['cognome'] = NULL;
    $_SESSION['notifiche'] = NULL;
    $_SESSION['ruolo'] = NULL;
    $_SESSION['ragSociale'] = NULL;

    session_destroy();
}

function isActive($pagename){
    if(basename($_SERVER['PHP_SELF']) == $pagename){
        echo "active";
    }
}

// Set dei parametri obj template
function setTemplateParams($title, $pageName, $params = array()) {
    global $templateParams;
    $templateParams['title'] = $title;
    $templateParams['name'] = $pageName;    
    foreach($params as $key => $value) {        
        $templateParams[$key] = $value;
    }
    return $templateParams;
}

?>