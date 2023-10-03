<?php
include_once('connection.php');
session_start();

// Check if the user has confirmed making the user an admin
if (isset($_POST['confirm'])) {
    // Retrieve the user's ID from the URL parameter
    $userId = $_GET['id']; // Make sure to sanitize and validate this input
    if (empty($userId)) {
        // Handle missing or invalid ID
        $message = "Invalid user ID";
    } else {
        // Check if the user is already an admin
        $isAdminQuery = "SELECT Role FROM users WHERE id='$userId' AND Role='Admin'";
        $isAdminResult = $mysqli->query($isAdminQuery);

        if ($isAdminResult->num_rows > 0) {
            // User is already an admin
            $message = "User is already an Admin. Going back to Dashboard!";
            $direct_after_already_admin = true;
        } else {
            // Set the "Admin" role in the database for the selected user
            $updateQuery = "UPDATE users SET Role='Admin' WHERE id='$userId'";

            if ($mysqli->query($updateQuery)) {
                // Admin role set successfully, redirect to the dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $message = "Error setting admin role: " . $mysqli->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Setting Admin</title>

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
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="loading-message">
                <?php if (isset($message)): ?>
                    <h2><?php echo $message; ?></h2>
                <?php else: ?>
                    <h2>Are you sure you want to make this user an Admin?</h2>
                    <form method="POST">
                        <input type="hidden" name="confirm" value="1">
                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"> <!-- Pass the user's ID in the form -->
                        <input type="submit" class="btn btn-success" value="Make Admin">
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
