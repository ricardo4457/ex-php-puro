<?php
include 'controllers/auth.php';
include 'validations/loginValidation.php';

function emailExists($email)
{
   global $connection;

   $sql = "SELECT id FROM users WHERE email = ?";
   $search = $connection->prepare($sql);
   $search->bind_param('s', $email);
   $search->execute();
   $search->store_result();

   return $search->num_rows > 0; // Returns true if email exists, false otherwise
}

// Define an array to hold field names and corresponding validation functions
$validationRules = [
   'email' => 'validateEmail',
   'password' => 'validatePassword'
];

// Initialize errors array to store validation errors
$errors = [];

// Initialize a variable to store login failure message
$loginError = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // Initialize email and password variables
   $email = $_POST['email'] ?? '';
   $password = $_POST['password'] ?? '';

   // Loop through each field and validate using the defined validation rules
   foreach ($validationRules as $field => $validationFunction) {
      // Get the value of the field and validate it
      $value = $_POST[$field] ?? '';

      // Pass both the value and email to validatePassword function
      if ($field === 'password') {
         // If the field is password, we need to pass both password and email
         $error = $validationFunction($value, $email);
      } else {
         // For other fields, just pass the value
         $error = $validationFunction($value);
      }

      // If there's an error, store it in the errors array
      if ($error) {
         $errors[$field] = $error;
      }
   }

   // If there are no validation errors, attempt to login
   if (empty($errors)) {
      // Check if the email exists in the database
      if (emailExists($email)) {
         // Email exists, now check the password
         if (login($email, $password)) {
            // Login successful, redirect to overview page
            header('Location: overview.php');
            exit();
         } else {
            // Password is incorrect
            $loginError = "Password is incorrect.";
         }
      } else {
         // Email does not exist
         $loginError = "Email not found.";
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

                  <!-- Display login error message -->
                  <?php if (!empty($loginError)): ?>
                     <div class="alert alert-danger"><?php echo $loginError; ?></div>
                  <?php endif; ?>

                  <!-- Display validation errors -->
                  <?php if (!empty($errors)): ?>
                     <div class="alert alert-danger">
                        <ul>
                           <?php foreach ($errors as $error): ?>
                              <li><?php echo $error; ?></li>
                           <?php endforeach; ?>
                        </ul>
                     </div>
                  <?php endif; ?>

                  <form method="POST">
                     <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
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