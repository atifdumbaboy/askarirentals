<?php
include_once('connection.php');
session_start();
$username = $_SESSION['username'];

if (isset($_POST['submit'])) {
    $Location = $_POST['Location'];
    $Price = $_POST['Price'];
    $Contact = $_POST['Contact'];
    $Bathrooms = $_POST['Bathrooms'];
    $Rooms = $_POST['Rooms'];
    $Floors = $_POST['Floors'];
    $Area = $_POST['Area'];

    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $original_file_name = $_FILES['fileToUpload']['name'];

    // Get the file extension from the original filename
    $file_extension = pathinfo($original_file_name, PATHINFO_EXTENSION);

    // Define a custom filename format with the file extension
    $custom_filename = 'home_' . $username . '_' . time() . '_' . uniqid() . '.' . $file_extension;

    $target_directory = "media/homes/"; // Specify the target directory
    $target_path = $target_directory . $custom_filename;

    if (move_uploaded_file($file_tmp, $target_path)) {
        // Insert data into the database
        $sql = "INSERT INTO homes (Location, Price, Owner, Contact, Bathrooms, Rooms, Floors, Area, Picture) 
                VALUES ('$Location', '$Price', '$username', '$Contact', '$Bathrooms', '$Rooms', '$Floors', '$Area', '$custom_filename')";

        if ($mysqli->query($sql) === TRUE) {
            // Successful insertion
            header("Location: index.php"); // Redirect to a success page or wherever you want
            exit();
        } else {
            // Error in insertion
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logging Out</title>

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
    <meta http-equiv="refresh" content="2;url=index.php"> <!-- Redirect to index.php after 3 seconds -->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="loading-message">
                <i class="fas fa-home fa-5x"></i>
                <p>Adding Home...</p>
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

