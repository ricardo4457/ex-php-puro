<?php
include 'controllers/auth.php';

include 'validations/loginValidation.php';

// Define an array to hold field names and corresponding validation functions
$validationRules = [
   'email' => 'validateEmail',
   'password' => 'validatePassword'
];

// Initialize errors array to store any validation errors
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Loop through each field and validate
   foreach ($validationRules as $field => $validationFunction) {
      $$field = $_POST[$field] ?? ''; // Dynamically create variable name ( $email, $password)
      $error = $validationFunction($$field); // Call the validation function dynamically
      if ($error) {
         $errors[$field] = $error; // Add error to the errors array
      }
   }

   // If no errors, attempt login
   if (empty($errors)) {
      if (login($email, $password)) {
         header('Location: x');
         exit();
      } else {
         $errors['general'] = "Invalid email or password.";
      }
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