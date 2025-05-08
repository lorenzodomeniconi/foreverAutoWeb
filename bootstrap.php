<?php
session_start();
require_once("database/PHP/databaseHelper.php");
$db = new DatabaseHelper("localhost", "root", "", "foreverAuto", 3306);
?>