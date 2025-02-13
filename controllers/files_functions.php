<?php
include 'connection/db.php';


function getFileById($file_id)
{
   global $connection;

   $sql = "SELECT * FROM files WHERE id = ?";
   $search = $connection->prepare($sql);
   $search->bind_param('i', $file_id);
   $search->execute();
   $result = $search->get_result();

   return $result->fetch_assoc();
}

function addFile($user_id, $file_name, $temp_file)
{
   global $connection;

   // Define the upload directory
   $upload_dir = 'uploads/';

   // Ensure the upload directory exists
   if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0755, true);
   }

   // Generate a unique file name to avoid conflicts
   $unique_file_name = uniqid() . '_' . basename($file_name);
   $file_path = $upload_dir . $unique_file_name;

   // Move the uploaded file to the upload directory
   if (move_uploaded_file($temp_file, $file_path)) {
      // Save the file details in the database
      $sql = "INSERT INTO files (user_id, file_name, file_path) VALUES (?, ?, ?)";
      $stmt = $connection->prepare($sql);
      $stmt->bind_param('iss', $user_id, $file_name, $file_path);
      return $stmt->execute();
   }

   return false;
}

function getFiles($user_id)
{
   global $connection;

   $sql = "SELECT id, file_name, file_path, upload_date FROM files WHERE user_id = ?";
   $stmt = $connection->prepare($sql);
   $stmt->bind_param('i', $user_id);
   $stmt->execute();
   $result = $stmt->get_result();

   $files = [];
   while ($row = $result->fetch_assoc()) {
      $files[] = $row;
   }

   return $files;
}
