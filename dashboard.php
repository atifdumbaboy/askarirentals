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
// Query to retrieve homes owned by the logged-in user
$homes_query = "SELECT * FROM homes WHERE Owner='$username'";
$homes_result = $mysqli->query($homes_query);
?>

<?php // Include the header
include('header.php');
?>

<div class="container mt-5 min-vh-100">
    <div class="row">
        <div class="col-md-12 text-center">
            <!-- Display the user's profile picture -->
            <img src="media/profiles/<?php echo $profile_picture; ?>" alt="Profile Picture" class="img-fluid rounded-circle" style="max-width: 200px;">
            <h1>Welcome, <?php echo $username; ?>!</h1>
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
                        <input type="text" class="form-control" name="Owner" placeholder="Owner" required>
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
                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Your Listed homes-->
    <div class="row mt-5">
        <div class="col-md-12">
            <h2 class="text-center">Your Home Listings</h2>
            <!-- Display homes owned by the logged-in user -->
            <div class="row">
                <?php
                // Loop through the results and display each home
                while ($home_row = $homes_result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    if ($home_row['Picture'] == null || $home_row['Picture'] == '') {
                        // No image available
                    } else {
                        echo "<img src='media/" . $home_row['Picture'] . "' class='card-img-top' style='height: 200px;' />";
                    }
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">Location: ' . $home_row['Location'] . '</h5>';
                    // You can add more details here as needed
                    echo '<a href="details.php?id=' . $home_row['id'] . '" class="btn btn-primary">More Details</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>

        </div>
    </div>
</div>




<?php // Include the footer
include('footer.php');
?>
