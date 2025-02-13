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

                  <!-- Image Preview Container  -->
                  <div class="text-center mb-4">
                     <img id="imagePreview" src="#" alt="Image Preview" class="img-fluid d-none">
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