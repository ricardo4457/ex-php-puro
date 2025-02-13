<?php

function validateEmail($email)
{
   // Validate email format
   if (empty($email)) {
      return "Email is required.";
   } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return "Invalid email format.";
   }

   // Check if email exists in the database
   include 'connection/db.php'; // Include database connection
   $query = "SELECT id FROM users WHERE email = :email";
   $search = $pdo->prepare($query);
   $search->execute(['email' => $email]);

   if ($search->rowCount() === 0) {
      return "Email does not exist in our records.";
   }

   // If everything is valid, return an empty string
   return '';
}

// Function to validate password
function validatePassword($password, $email)
{
   // Validate password format
   if (empty($password)) {
      return "Password is required.";
   } elseif (strlen($password) < 6) {
      return "Password must be at least 6 characters.";
   }

   // Check if the password matches the hashed password in the database
   include 'connection/db.php'; // Include database connection

   // Fetch the hashed password for the given email
   $query = "SELECT password FROM users WHERE email = :email";
   $search = $pdo->prepare($query);
   $search->execute(['email' => $email]);
   $user = $search->fetch();

   if (!$user) {
      return "User not found.";
   }

   // If everything is valid, return an empty string
   return '';
}
