<?php
include 'connection/db.php';

session_start();

function login($email, $password)
{
    global $connection;

    // Hash the input password using SHA-256
    $hashed_input_password = hash('sha256', $password);

    // Query to select user by email
    $sql = "SELECT id, password FROM users WHERE email = ?";
    $query = $connection->prepare($sql);
    $query->bind_param('s', $email);
    $query->execute();
    $query->store_result();
    $query->bind_result($id, $hashed_password);

    // If user exists and the hashed password matches
    if ($query->fetch() && $hashed_input_password === $hashed_password) {
        // Store user ID in session
        $_SESSION['user_id'] = $id;
        return true;  // Successful login
    } else {
        return false;  // Invalid login
    }
}
