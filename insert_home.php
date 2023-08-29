<?php
include_once('connection.php');
session_start();
$username = $_SESSION['username'];

if (isset($_POST['submit'])) {
    $Location = $_POST['Location'];
    $Price = $_POST['Price'];
    $Owner = $_POST['Owner'];
    $Contact = $_POST['Contact'];
    $Bathrooms = $_POST['Bathrooms'];
    $Rooms = $_POST['Rooms'];
    $Floors = $_POST['Floors'];
    $Area = $_POST['Area'];

    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_name = $_FILES['fileToUpload']['name'];
    $target_directory = "media/"; // Specify the target directory

    $target_path = $target_directory . $file_name;

    if (move_uploaded_file($file_tmp, $target_path)) {
        // Insert data into the database
        $sql = "INSERT INTO homes (Location, Price, Owner, Contact, Bathrooms, Rooms, Floors, Area, Picture) 
                VALUES ('$Location', '$Price', '$Owner', '$Contact', '$Bathrooms', '$Rooms', '$Floors', '$Area', '$file_name')";

        if ($mysqli->query($sql) === TRUE) {
            // Successful insertion
            header("Location: index.php"); // Redirect to a success page or wherever you want
            exit();
        } else {
            // Error in insertion
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    } else {
        echo "Error moving the uploaded file.";
    }
}
?>
