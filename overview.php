<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>Overview</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
   <div class="container mt-5">
      <div class="row justify-content-center">
         <div class="col-md-6">
            <div class="card shadow">
               <div class="card-body text-center">
                  <h1 class="card-title">Welcome!</h1>
                  <p>What would you like to do?</p>
                  <div class="d-grid gap-2">
                     <a href="profile.php" class="btn btn-primary">My Profile</a>
                     <a href="files.php" class="btn btn-secondary">My Files</a>
                     <a href="logout.php" class="btn btn-danger">Logout</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</body>

</html>