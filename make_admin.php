<?php
include_once('connection.php');
session_start();
$username = $_SESSION['username'];

// Check if an 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Query to retrieve the user's data based on the provided 'id'
    $query = "SELECT * FROM users WHERE id='$user_id'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        // User data found
        $user_data = $result->fetch_assoc();

        // Check if the user is already an admin
        if ($user_data['Role'] == 'Admin') {
            // User is already an admin, display a message and redirect
            echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>Make Admin</title>
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
                        }
                        .message {
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="message">
                                    <h2>User is already an Admin. Redirecting...</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Include Bootstrap JS and jQuery -->
                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                    <script>
                        setTimeout(function() {
                            window.location.href = "dashboard.php"; // Redirect after 3 seconds
                        }, 3000);
                    </script>
                </body>
                </html>';
            exit();
        } else {
            // Set the "Admin" role in the database for the selected user
            $updateQuery = "UPDATE users SET Role='Admin' WHERE id='$user_id'";

            if ($mysqli->query($updateQuery)) {
                // Admin role set successfully, display a message and redirect
                echo '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <title>Make Admin</title>
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
                            }
                            .message {
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="message">
                                        <h2>User is now an Admin. Redirecting...</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Include Bootstrap JS and jQuery -->
                        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                        <script>
                            setTimeout(function() {
                                window.location.href = "dashboard.php"; // Redirect after 3 seconds
                            }, 3000);
                        </script>
                    </body>
                    </html>';
                exit();
            } else {
                // Error setting admin role
                echo "Error setting admin role: " . $mysqli->error;
            }
        }
    } else {
        // User with the provided ID does not exist
        echo "User not found.";
    }
} else {
    // No 'id' parameter provided in the URL
    echo "Invalid request.";
}
?>
