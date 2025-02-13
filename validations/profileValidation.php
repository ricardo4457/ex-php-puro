<?php
// Function to validate name
function validateName($name)
{

   if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
      return "Only letters and spaces are allowed in the name.";
   }
   return '';
}

// Function to validate birthdate
function validateBirthdate($birthdate)
{

   if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthdate)) {
      return "Invalid date format. Use YYYY-MM-DD.";
   }
   return '';
}

// Function to validate phone number
function validatePhone($phone)
{
   if (!preg_match("/^[0-9]{9}$/", $phone)) {
      return "Invalid phone number. Must be 9 digits.";
   }
   return '';
}

// Function to validate profile photo
function validateProfilePhoto($file)
{
   // Check file type (allow only JPEG and PNG, disallow GIF)
   $allowed_types = ['image/jpeg', 'image/png']; // Only JPEG and PNG allowed
   if (!in_array($file['type'], $allowed_types)) {
      return "Invalid file type. Only JPEG and PNG are allowed.";
   }

   // Check file size (limit to 6MB)
   $max_size = 6 * 1024 * 1024; // 6MB
   if ($file['size'] > $max_size) {
      return "File size exceeds the maximum limit of 6MB.";
   }

   return '';
}
