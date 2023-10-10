<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'asm2-php';

try {
    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);

}catch (PDOException $PDOException){
    echo $PDOException->getMessage();
}