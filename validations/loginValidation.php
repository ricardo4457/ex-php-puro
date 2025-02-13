<?php
// Function to validate email
function validateEmail($email) {
    if (empty($email)) {
        return "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }
    return '';
}

// Function to validate password
function validatePassword($password) {
    if (empty($password)) {
        return "Password is required.";
    } elseif (strlen($password) < 6) {
        return "Password must be at least 6 characters.";
    }
    return '';
}
?>
