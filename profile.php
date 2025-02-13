<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
   header('Location: index.php');
   exit;
}

include 'controllers/profile_functions.php';
include 'validations/profileValidation.php'; // Include validation functions

$user_id = $_SESSION['user_id'];

// Initialize errors array
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // Get form data
   $name = $_POST['name'] ?? '';
   $birthdate = $_POST['birthdate'] ?? '';
   $phone = $_POST['phone'] ?? '';
   $profile_photo = $_FILES['profile_photo'] ?? [];

   // Get the existing profile data
   $profile = getProfile($user_id);

   // Define validation rules
   $validationRules = [
      'name' => 'validateName',
      'birthdate' => 'validateBirthdate',
      'phone' => 'validatePhone',
      'profile_photo' => 'validateProfilePhoto',
   ];

   // Validate only changed fields
   foreach ($validationRules as $field => $validationFunction) {
      $value = ($field == 'profile_photo') ? $profile_photo : $_POST[$field] ?? '';

      // Check if the field has changed
      if ($field == 'profile_photo') {
         // For file uploads, check if a new file is uploaded
         if ($profile_photo && $profile_photo['error'] == 0) {
            $error = $validationFunction($value); // Validate only if a new file is uploaded
            if ($error) {
               $errors[$field] = $error;
            }
         }
      } else {
         // For other fields, check if the value has changed
         if ($value != $profile[$field]) {
            $error = $validationFunction($value); // Validate only if the value has changed
            if ($error) {
               $errors[$field] = $error;
            }
         }
      }
   }

   // If no errors, proceed with updating the profile
   if (empty($errors)) {
      $uploads_folder = __DIR__ . '/uploads/';

      // Create uploads directory if it doesn't exist
      if (!is_dir($uploads_folder)) {
         mkdir($uploads_folder, 0777, true);
      }

      // Handle file upload
      $profile_photo_name = null;
      if ($profile_photo && $profile_photo['error'] == 0) {
         // A new image is uploaded
         $original_file_name = basename($profile_photo['name']);
         $unique_file_name = $user_id . '_' . time() . '_' . $original_file_name;
         $profile_photo_path = $uploads_folder . $unique_file_name;

         if (move_uploaded_file($profile_photo['tmp_name'], $profile_photo_path)) {
            $profile_photo_name = $unique_file_name; // Save the unique file name (not the full path)
         } else {
            $errors['profile_photo'] = "File upload failed. Check folder permissions.";
         }
      } else {
         // No new image is uploaded, retain the existing image
         $profile_photo_name = $profile['profile_photo'];
      }

      // Update profile if no errors
      if (empty($errors)) {
         // Call the updated updateProfile function
         updateProfile($user_id, $name, $birthdate, $phone, $profile_photo_name); // Save only the filename
         header('Location: profile.php'); // Redirect to avoid form resubmission
         exit();
      }
   }
}

$profile = getProfile($user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>My Profile</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
      #imagePreview {
         max-width: 100%;
         height: auto;
         border-radius: 8px;
         margin-top: 10px;
      }
   </style>
</head>

<body class="bg-light">
   <div class="container mt-5">
      <div class="row justify-content-center">
         <div class="col-md-8">
            <div class="card shadow">
               <div class="card-body">
                  <h1 class="card-title text-center">My Profile</h1>

                  <!-- Image Preview Container -->
                  <div class="text-center mb-4">
                     <img id="imagePreview" src="<?php echo !empty($profile['profile_photo']) ? 'uploads/' . $profile['profile_photo'] : '#'; ?>"
                        alt="Image Preview" class="img-fluid <?php echo empty($profile['profile_photo']) ? 'd-none' : ''; ?>">
                  </div>

                  <form method="POST" enctype="multipart/form-data">
                     <!-- Name Field -->
                     <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $profile['name']; ?>" required>
                        <?php if (isset($errors['name'])): ?>
                           <div class="text-danger"><?php echo $errors['name']; ?></div>
                        <?php endif; ?>
                     </div>

                     <!-- Birthdate Field -->
                     <div class="mb-3">
                        <label for="birthdate" class="form-label">Birthdate:</label>
                        <input type="date" name="birthdate" class="form-control" value="<?php echo $profile['birthdate']; ?>">
                        <?php if (isset($errors['birthdate'])): ?>
                           <div class="text-danger"><?php echo $errors['birthdate']; ?></div>
                        <?php endif; ?>
                     </div>

                     <!-- Phone Field -->
                     <div class="mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $profile['phone']; ?>">
                        <?php if (isset($errors['phone'])): ?>
                           <div class="text-danger"><?php echo $errors['phone']; ?></div>
                        <?php endif; ?>
                     </div>

                     <!-- Profile Photo Field -->
                     <div class="mb-3">
                        <label for="profile_photo" class="form-label">Profile Photo:</label>
                        <!-- File input for profile photo -->
                        <input type="file" name="profile_photo" id="profile_photo" class="form-control" onchange="previewImage(event)">

                        <?php if (isset($errors['profile_photo'])): ?>
                           <div class="text-danger"><?php echo $errors['profile_photo']; ?></div>
                        <?php endif; ?>
                     </div>

                     <!-- Submit Button -->
                     <button type="submit" class="btn btn-primary w-100">Save</button>
                  </form>

                  <!-- Navigation Buttons -->
                  <div class="mt-3 text-center">
                     <a href="overview.php" class="btn btn-secondary">Back to Overview</a>
                     <a href="logout.php" class="btn btn-danger">Logout</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script>
      function previewImage(event) {
         const reader = new FileReader();
         const imagePreview = document.getElementById('imagePreview');

         reader.onload = function() {
            imagePreview.src = reader.result;
            imagePreview.classList.remove('d-none'); // Show the image preview
         };

         if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]); // Read the selected file
         } else {
            imagePreview.src = "#";
            imagePreview.classList.add('d-none'); // Hide the image preview if no file is selected
         }
      }
   </script>
</body>

</html>