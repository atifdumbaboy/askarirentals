<?php
include_once('connection.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to a login page or display an error message
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$profileDeleted = false; // Initialize the flag

// Check if the user has confirmed the profile deletion
if (isset($_POST['confirm'])) {
    // Get the user's current profile picture filename
    $profilePicture = $mysqli->query("SELECT `Profile Picture` FROM users WHERE Name='$username'")->fetch_assoc()['Profile Picture'];

    // Delete the user's profile picture file if it exists
    if (!empty($profilePicture)) {
        $profilePicturePath = "media/profiles/" . $profilePicture;
        if (file_exists($profilePicturePath)) {
            unlink($profilePicturePath); // Delete the file
        }
    }

    // Perform the profile deletion
    $deleteQuery = "DELETE FROM users WHERE Name='$username'";
    if ($mysqli->query($deleteQuery)) {
        // Profile deleted successfully, set the flag
        $profileDeleted = true;
        // Destroy the session
        session_destroy();
    } else {
        $message = "Error deleting profile: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deleting Profile</title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome for the loading icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url("media/statics/loading.png");
        }

        .loading-message {
            text-align: center;
        }
    </style>
    <?php if ($profileDeleted): ?>
        <meta http-equiv="refresh" content="3;url=signup.php"> <!-- Redirect to signup.php after 3 seconds -->
    <?php endif; ?>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="loading-message">
                <?php if ($profileDeleted): ?>
                    <i class="fas fa-trash fa-5x" style="color: red;"></i>
                    <h2>Deleting Profile...</h2>
                <?php else: ?>
                    <h2>Are you sure you want to delete your profile? This action cannot be undone.</h2>
                    <form method="POST">
                        <input type="submit" class="btn btn-danger" name="confirm" value="Confirm Deletion">
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
