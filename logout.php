<?php
require_once("bootstrap.php");

logOut();

header("location: " . Pages::INDEX->value);
?>