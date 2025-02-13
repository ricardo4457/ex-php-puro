<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
   header('Location: index.php');
   exit;
}

include 'controllers/profile_functions.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $name = $_POST['name'];
   $birthdate = $_POST['birthdate'];
   $phone = $_POST['phone'];

   $profile_photo = null;
   $uploads_folder = __DIR__ . '/uploads/'; // Stay in the current directory

   // Make sure the uploads directory exists and is writable
   if (!is_dir($uploads_folder)) {
      mkdir($uploads_folder, 0777, true); // Create the directory if it doesn't exist
   }

   $original_file_name = basename($_FILES['profile_photo']['name']);
   $unique_file_name = $user_id . '_' . time() . '_' . $original_file_name;
   $profile_photo_path = $uploads_folder . $unique_file_name;

   if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $profile_photo_path)) {
      $profile_photo = $unique_file_name; // Save only the file name (not the full path)
   } else {
      echo "File upload failed. Check folder permissions.";
   }

   // Update the profile with only the file name
   updateProfile($user_id, $name, $birthdate, $phone, $profile_photo);
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
                     <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $profile['name']; ?>" required>
                     </div>
                     <div class="mb-3">
                        <label for="birthdate" class="form-label">Birthdate:</label>
                        <input type="date" name="birthdate" class="form-control" value="<?php echo $profile['birthdate']; ?>">
                     </div>
                     <div class="mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $profile['phone']; ?>">
                     </div>
                     <div class="mb-3">
                        <label for="profile_photo" class="form-label">Profile Photo:</label>
                        <input type="file" name="profile_photo" id="profile_photo" class="form-control" onchange="previewImage(event)">
                     </div>
                     <button type="submit" class="btn btn-primary w-100">Save</button>
                  </form>
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