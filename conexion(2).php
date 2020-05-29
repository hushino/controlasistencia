<?php

$server = 'localhost';
$username = 'shhhc32_root';
$password = '~39K5He(MhZT';
$database = 'shhhc32_yisus';

try {
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
   
} catch (PDOException $e) {
    die('Conexion fallida: lo sentimos mucho.'.$e->getMessage());
}



?>