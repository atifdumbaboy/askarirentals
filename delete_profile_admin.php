<?php
include_once('connection.php');
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['username']) || $_SESSION['Role'] !== 'Admin') {
    // Redirect to a login page or display an error message
    header("Location: login.php");
    exit();
}

$profileDeleted = false; // Initialize the flag

// Check if an ID is passed via the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id']; // Retrieve the user's ID from the URL parameter

    // Make sure the $userId is not empty or null
    if (!empty($userId)) {
        // Query the user's information based on the ID
        $userQuery = "SELECT `Profile Picture` FROM users WHERE id='$userId'";
        $userResult = $mysqli->query($userQuery);

        if ($userResult->num_rows > 0) {
            // User with the provided ID found
            $userData = $userResult->fetch_assoc();

            // Check if the user has confirmed the profile deletion
            if (isset($_POST['confirm'])) {
                // Get the user's current profile picture filename
                $profilePicture = $userData['Profile Picture'];

                // Delete the user's profile picture file if it exists
                if (!empty($profilePicture)) {
                    $profilePicturePath = "media/profiles/" . $profilePicture;
                    if (file_exists($profilePicturePath)) {
                        unlink($profilePicturePath); // Delete the file
                    }
                }

                // Perform the profile deletion
                $deleteQuery = "DELETE FROM users WHERE id='$userId'";
                if ($mysqli->query($deleteQuery)) {
                    // Profile deleted successfully, set the flag
                    $profileDeleted = true;
                } else {
                    $message = "Error deleting profile: " . $mysqli->error;
                }
            }
        } else {
            // User with the provided ID not found
            $message = "User not found.";
        }
    } else {
        // Handle missing or invalid ID
        $message = "Invalid user ID.";
    }
} else {
    // No ID provided in the URL
    $message = "No user ID provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Rest of your HTML head section -->
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
                    <h2>Are you sure you want to delete this profile? This action cannot be undone.</h2>
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
