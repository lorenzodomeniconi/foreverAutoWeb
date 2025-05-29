<?php
require_once("bootstrap.php");
$db->deleteVehicle($_POST['numTelaio']);
header("location: " . Pages::INDEX->value);
?>