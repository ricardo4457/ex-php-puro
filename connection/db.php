<?php
$server = 'localhost';
$database = 'employee_management';
$user = 'root';
$password = '';

$connection = new mysqli($server, $user, $password, $database);

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$server;dbname=$database", $user, $password);
} catch (PDOException $e) {
    // Catch any connection error and display a message
    die("Connection failed: " . $e->getMessage());
}
