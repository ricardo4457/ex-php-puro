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

function addFile($user_id, $file_name, $temp_file) {
   global $connection;

   // Check if a file with the same name already exists for the user
   $sql = "SELECT id FROM files WHERE user_id = ? AND file_name = ?";
   $search = $connection->prepare($sql);
   $search->bind_param('is', $user_id, $file_name);
   $search->execute();
   $search->store_result();

   if ($search->num_rows > 0) {
       // A file with the same name already exists
       return false;
   }

   // Define the path where the file will be stored
   $uploads_folder = __DIR__ . '/../uploads/'; // Absolute path to the "uploads" folder
   $file_path = $uploads_folder . basename($file_name);

   // Move the file to the "uploads" folder
   if (move_uploaded_file($temp_file, $file_path)) {
       // Insert the file path into the database
       $sql = "INSERT INTO files (user_id, file_name, file_path) VALUES (?, ?, ?)";
       $search = $connection->prepare($sql);
       $search->bind_param('iss', $user_id, $file_name, $file_path);
       return $search->execute();
   } else {
       return false; // Failed to move the file
   }
}

function getFiles($user_id)
{
   global $connection;

   $sql = "SELECT id, file_name, file_path, upload_date FROM files WHERE user_id = ?";
   $search = $connection->prepare($sql);
   $search->bind_param('i', $user_id);
   $search->execute();
   $result = $search->get_result();

   $files = [];
   while ($row = $result->fetch_assoc()) {
      $files[] = $row;
   }

   return $files;
}


function deleteFile($file_id, $user_id)
{
   global $connection;

   // Fetch the file details (including the file path)
   $sql = "SELECT file_path FROM files WHERE id = ? AND user_id = ?";
   $search = $connection->prepare($sql);
   $search->bind_param('ii', $file_id, $user_id);
   $search->execute();
   $result = $search->get_result();
   $file = $result->fetch_assoc();

   if ($file) {
      // Delete the file from the local file system
      if (file_exists($file['file_path'])) {
         if (unlink($file['file_path'])) {
            // File deleted successfully from the file system
         } else {
            return false; // Failed to delete the file locally
         }
      }

      // Delete the file record from the database
      $sql = "DELETE FROM files WHERE id = ?";
      $search = $connection->prepare($sql);
      $search->bind_param('i', $file_id);
      return $search->execute();
   }

   return false; // File not found or user not authorized
}
