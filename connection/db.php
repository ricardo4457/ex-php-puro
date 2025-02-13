<?php
$server = 'localhost';
$database = 'employee_management';
$user = 'root';
$password = '';

$connection = new mysqli($server, $user, $password, $database);

if ($connection->connect_error) {
    die("Connection error: " . $connection->connect_error);
}
?>