<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

include 'controllers/files_functions.php';

// Get the file ID from the query string
if (isset($_GET['file_id'])) {
    $file_id = $_GET['file_id'];
    $file = getFileById($file_id);

    if ($file && $file['user_id'] == $_SESSION['user_id']) {
        // Display the image
        $file_path = $file['file_path'];
        $file_name = $file['file_name'];
        $file_type = mime_content_type($file_path);

        header("Content-Type: $file_type");
        header("Content-Disposition: inline; filename=\"$file_name\"");
        readfile($file_path);
        exit;
    }
}

// If the file is not found or the user is not authorized, redirect to the files page
header('Location: files.php');
exit;
?>