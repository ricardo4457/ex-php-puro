<?php
function validateFileSize($file) {
   // Define maximum file size 
   $max_file_size = 30 * 1024 * 1024; // 30MB in bytes

   // Check for upload errors
   if ($file['error'] !== UPLOAD_ERR_OK) {
       return "Error uploading file. Please try again.";
   }

   // Validate file size
   if ($file['size'] > $max_file_size) {
       return "File size exceeds the maximum limit of 30MB.";
   }

   // Return true if validation passes
   return true;
}