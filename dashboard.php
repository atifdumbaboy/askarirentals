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
?>

<?php // Include the header
include('header.php');
?>

    <div class="welcome">
        <h1>Welcome, <?php echo $username; ?>!</h1>
    </div>
    <div class="container">
        <div class="centered-form">
            <h2>Add a New Home</h2>
            <form method="POST" action="insert_home.php" enctype="multipart/form-data">
                <input type="text" name="Location" placeholder="Location" required>
                <input type="number" name="Price" placeholder="Price" required>
                <input type="text" name="Owner" placeholder="Owner" required>
                <input type="text" name="Contact" placeholder="Contact No" required>
                <input type="number" name="Bathrooms" placeholder="Number of Bathrooms?" required>
                <input type="number" name="Rooms" placeholder="Number of Rooms?" required>
                <input type="number" name="Floors" placeholder="Number of Floors?" required>
                <input type="text" name="Area" placeholder="Area of House?" required>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </div>

<?php // Include the footer
include('footer.php');
session_destroy();
?>
