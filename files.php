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
                                    <a href="<?php echo $file['file_path']; ?>" download>
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