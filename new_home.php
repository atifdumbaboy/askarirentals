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

// Query to retrieve the user's profile picture filename
$query = "SELECT `Profile Picture` FROM users WHERE Name='$username'";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profile_picture = $row['Profile Picture'];
} else {
    $profile_picture = ''; // Default profile picture if not found
}

?>

<?php // Include the header
include('header.php');
?>


<div class="container mt-5 min-vh-100">
    <div class="row">
        <div class="col-md-12 text-center dash">
            <!-- Display the user's profile picture -->
            <img src="media/profiles/<?php echo $profile_picture; ?>" alt="Profile Picture" id="hoverBaby" class="img-fluid rounded-circle" style="max-width: 200px;" onmouseover="this.style.border='4px solid #4CAF50';"
                 onmouseout="this.style.border='none';">
            <h1 style="margin-bottom: 40px; margin-top: 40px">Welcome, <?php echo $username; ?>!</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="centered-form">
                <h2 class="text-center">Add a New Home</h2>
                <form method="POST" action="insert_home.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" name="Location" placeholder="Location" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="Price" placeholder="Price" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="Contact" placeholder="Contact No" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="Bathrooms" placeholder="Number of Bathrooms?" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="Rooms" placeholder="Number of Rooms?" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="Floors" placeholder="Number of Floors?" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="Area" placeholder="Area of House?" required>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php // Include the footer
include('footer.php');
?>


