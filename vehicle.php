<?php
require_once("bootstrap.php");

if (!isset($_GET['telaio'])) {
    header("Location: " . Pages::INDEX->value);
    exit;
}

if (isset($_SESSION['erroreCarrello'])): ?>
    <div class="alert alert-warning text-center py-2 alert-dismissible fade show" role="alert" onclick="this.style.display='none';" style="position: fixed; top: 0; left: 0; width: 100%; z-index: 1050;">
        <?php echo $_SESSION["erroreCarrello"]; ?>        
    </div>
<?php endif; 
$_SESSION['erroreCarrello'] = null;

$telaio = $_GET['telaio'];
$vehicle = $db->getVehicleByNumTelaio($telaio);
if (!$vehicle) {
    header("Location: index.php");
    exit;
}

setTemplateParams("ForeverAuto - Dettaglio Veicolo", "templates/" . Pages::SINGLE_VEHICLE->value, 
    array("vehicle" => $vehicle
));

require "templates/" . Pages::BASE->value;
?>
