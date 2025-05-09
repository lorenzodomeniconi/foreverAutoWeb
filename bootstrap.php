<?php
session_start();
require_once("database/PHP/databaseHelper.php");
require_once("utils/utils.php");
$db = new DatabaseHelper("localhost", "root", "", "foreverAuto", 3306);
?>