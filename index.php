<?php
include 'controllers/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $email = $_POST['email'];
   $password = $_POST['password'];

   if (login($email, $password)) {
      header('Location: x');
      exit();
   } else {
      $error_message = "Incorrect email or password.";
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>Login</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
   <div class="container mt-5">
      <div class="row justify-content-center">
         <div class="col-md-6">
            <div class="card shadow">
               <div class="card-body">
                  <h1 class="card-title text-center">Login</h1>
                  <?php if (isset($error_message)): ?>
                     <div class="alert alert-danger"><?php echo $error_message; ?></div>
                  <?php endif; ?>
                  <form method="POST">
                     <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" required>
                     </div>
                     <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                     </div>
                     <button type="submit" class="btn btn-primary w-100">Login</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</body>

</html>