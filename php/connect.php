<?php

$database = 'bingo';
$dbusername = 'root';
$dbpassword = '';
$url = 'localhost';

//new pdo connection
$connection = new PDO("mysql:host=$url;port=3306;dbname=$database", $dbusername);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>