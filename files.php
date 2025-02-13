<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
   header('Location: index.php');
   exit;
}

include 'controllers/files_functions.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   if ($_FILES['file']['error'] == 0) {
      $file_name = $_FILES['file']['name'];
      $temp_file = $_FILES['file']['tmp_name'];

      if (addFile($user_id, $file_name, $temp_file)) {
         $success_message = "File uploaded successfully!";
      } else {
         $error_message = "Error uploading file.";
      }
   }
}

$files = getFiles($user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>My Files</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
   <div class="container mt-5">
      <div class="row justify-content-center">
         <div class="col-md-8">
            <div class="card shadow">
               <div class="card-body">
                  <h1 class="card-title text-center">My Files</h1>
                  <?php if (isset($success_message)): ?>
                     <div class="alert alert-success"><?php echo $success_message; ?></div>
                  <?php endif; ?>
                  <?php if (isset($error_message)): ?>
                     <div class="alert alert-danger"><?php echo $error_message; ?></div>
                  <?php endif; ?>
                  <form method="POST" enctype="multipart/form-data">
                     <div class="mb-3">
                        <label for="file" class="form-label">Upload File:</label>
                        <input type="file" name="file" class="form-control">
                     </div>
                     <button type="submit" class="btn btn-primary w-100">Upload</button>
                  </form>

                  <h2 class="mt-4">Uploaded Files</h2>
                  <ul class="list-group">
                     <?php foreach ($files as $file): ?>
                        <li class="list-group-item">
                           <a href="view_image.php?file_id=<?php echo $file['id']; ?>" target="_blank">
                              <?php echo htmlspecialchars($file['file_name']); ?>
                           </a>
                           <small class="text-muted">(Uploaded on: <?php echo $file['upload_date']; ?>)</small>
                        </li>
                     <?php endforeach; ?>
                  </ul>

                  <div class="mt-3 text-center">
                     <a href="overview.php" class="btn btn-secondary">Back to Overview</a>
                     <a href="logout.php" class="btn btn-danger">Logout</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</body>

</html>