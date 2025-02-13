<?php
include 'controllers/auth.php';
include 'validations/loginValidation.php';

// Define an array to hold field names and corresponding validation functions
$validationRules = [
   'email' => 'validateEmail',
   'password' => 'validatePassword'
];

// Initialize errors array to store validation errors
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // Initialize email and password variables
   $email = $_POST['email'] ?? '';
   $password = $_POST['password'] ?? '';

   // Loop through each field and validate using the defined validation rules
   foreach ($validationRules as $field => $validationFunction) {
      // Get the value of the field and validate it
      $value = $_POST[$field] ?? '';
      $error = $validationFunction($value);

      // If there's an error, store it in the errors array
      if ($error) {
         $errors[$field] = $error;
      }
   }

   // If there are no errors, attempt to login
   if (empty($errors) && login($email, $password)) {
      header('Location: overview.php');
      exit();
   } else {
      $errors['general'] = "INTERNAL ERROR";
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
                  <form method="POST">
                     <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" required>
                        <!-- Display email validation error -->
                        <?php if (isset($errors['email'])): ?>
                           <div class="text-danger"><?php echo $errors['email']; ?></div>
                        <?php endif; ?>
                     </div>
                     <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                        <!-- Display password validation error -->
                        <?php if (isset($errors['password'])): ?>
                           <div class="text-danger"><?php echo $errors['password']; ?></div>
                        <?php endif; ?>
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