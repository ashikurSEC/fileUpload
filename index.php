<?php
session_start();

$allowed_extensions = ['jpg', 'jpeg', 'png'];

$max_file_size      = 5 * 1024 * 1024; // 20MB

if ( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['photo'])) {
    $file_name      = $_FILES['photo']['name'];
    $file_size      = $_FILES['photo']['size'];
    $file_tmp       = $_FILES['photo']['tmp_name'];
    $file_type      = $_FILES['photo']['type'];
    $file_ext       = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array( $file_ext, $allowed_extensions )) {
        if (empty($_FILES['photo']['name'])) {
            $_SESSION['message']   = "Please Choose a Picture..!!!";
        }
    } elseif ( $file_size  > $max_file_size ) {
        $_SESSION['message'] = "File size must be less than 2MB";
    }else {
        $upload_dir   = "uploads/";
        $destination  = $upload_dir .$file_name;

        if (move_uploaded_file( $file_tmp, $destination )) {
            $_SESSION['message']  = "File uploaded successfull";
        }else {
            $_SESSION['message']  = "Error uploading file.";
        }
    }
    header('location: index.php');
    exit();
    
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  <?php
    if (isset($_SESSION['message'])) {
    ?>
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Message...</strong><?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
        unset($_SESSION['message']);
    }
    ?>

  <div class="container mt-5">
        <form action="index.php" method="post" enctype="multipart/form-data">
            
            <h2 class="mb-4">Upload File</h2>
            <div class="mb-3">
                <label for="fileSelect" class="form-label">Filename:</label>
                <input type="file" class="form-control" name="photo" id="fileSelect">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Upload</button>
            
            <p class="mt-3"><strong>Note:</strong> Only .jpg, .jpeg, .png formats allowed to a max size of 5MB.</p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>