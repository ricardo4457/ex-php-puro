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
   // Ensure format YYYY-MM-DD using regex
   if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthdate)) {
      return "Invalid date format. Use YYYY-MM-DD.";
   }

   // Extract year, month, and day
   list($year, $month, $day) = explode('-', $birthdate);

   // Ensure it is a valid date
   if (!checkdate((int)$month, (int)$day, (int)$year)) {
      return "Invalid date.";
   }

   // Set realistic birth date constraints
   $minYear = date('Y') - 100; // Maximum 100 years old
   $maxYear = date('Y'); // Cannot be in the future

   if ($year < $minYear || $year > $maxYear) {
      return "Birthdate is unrealistic.";
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
   // Check file type (allow only JPEG and PNG)
   $allowed_types = ['image/jpeg', 'image/png']; 
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
