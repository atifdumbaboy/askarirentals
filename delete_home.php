<?php
include_once('connection.php');
session_start();
$username = $_SESSION['username'];

// Check if an 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $home_id = $_GET['id';

    // Query to retrieve the home details based on the provided 'id'
    $query = "SELECT * FROM homes WHERE id='$home_id' AND Owner='$username'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $home_data = $result->fetch_assoc();

        // Delete the home entry from the database
        $delete_query = "DELETE FROM homes WHERE id='$home_id'";
        if ($mysqli->query($delete_query)) {
            // Delete the home's picture from the 'media/homes' folder
            $picture_filename = $home_data['Picture'];
            if (!empty($picture_filename)) {
                $picture_path = "media/homes/" . $picture_filename;
                if (file_exists($picture_path)) {
                    unlink($picture_path);
                }
            }

            // Delete associated slider images
            for ($i = 1; $i <= 3; $i++) {
                $sliderImage = $home_data["SliderImage$i"];
                if (!empty($sliderImage)) {
                    $sliderImagePath = "media/homes/sliders/" . $sliderImage;
                    if (file_exists($sliderImagePath)) {
                        unlink($sliderImagePath);
                    }
                }
            }

            // Redirect to the dashboard or another page after successful deletion
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error deleting home: " . $mysqli->error;
        }
    } else {
        // Home with the provided ID does not belong to the user
        echo "You do not have permission to delete this home.";
    }
} else {
    // No 'id' parameter provided in the URL
    echo "Invalid request.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deleting Home</title>

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
    <meta http-equiv="refresh" content="2;url=dashboard.php"> <!-- Redirect to dashboard.php after 3 seconds -->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="loading-message">
                <i class="fas fa-trash fa-5x" style="color: red;"></i>
                <p>Deleting Home...</p>
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

