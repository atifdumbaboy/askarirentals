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

$queryAdmin = "SELECT `Role` FROM users WHERE Name='$username'";
$searchAdmin = $mysqli->query($queryAdmin);
$isAdmin = false;

if ($searchAdmin->num_rows > 0) {
    $row = $searchAdmin->fetch_assoc();
    if ($row['Role'] == 'Admin') {
        $isAdmin = true;
    }
}

if ($isAdmin) {
    // User is an admin, generate queries to fetch all homes and all profiles
    $AllHomes = "SELECT * FROM homes";
    $AllProfiles = "SELECT * FROM users";

    // Execute the queries to fetch all homes and all profiles
    $All_homes_result = $mysqli->query($AllHomes);
    $All_users_result = $mysqli->query($AllProfiles);
} else {
    $All_homes_result = null;
    $All_users_result = null;
}

?>


<?php // Include the header
include('header.php');
?>

<style>
    /* Style for the delete button */
    .delete-button {
        background-color: red;
        border: 1px solid #ff0000; /* Red border */
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* Shadow for 3D effect */
    }

    /* Style for the edit button (green) */
    .btn-success {
        background-color: green;
        border: 1px solid #00cc00; /* Green border */
        box-shadow: 2px 2px 5px rgba(0, 128, 0, 0.3); /* Shadow for 3D effect */
    }
</style>

<div class="container mt-5 min-vh-100">
    <div class="row">
        <div class="col-md-12 text-center">
            <!-- Display the user's profile picture -->
            <img src="media/profiles/<?php echo $profile_picture; ?>" alt="Profile Picture" class="img-fluid rounded-circle" style="max-width: 200px;" onmouseover="this.style.border='4px solid #4CAF50';"
                 onmouseout="this.style.border='none';">
            <h1 style="margin-top: 40px; margin-bottom: 40px">Welcome, <?php echo $username; ?>!</h1>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <a href="new_home.php" class="btn btn-primary">Add Home</a>
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
                // Display homes owned by the logged-in user
                    while ($home_row = $homes_result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card">';
                        if ($home_row['Picture'] == null || $home_row['Picture'] == '') {
                            // No image available
                        } else {
                            echo "<img src='media/homes/" . $home_row['Picture'] . "' class='card-img-top' style='height: 200px;' />";
                            // Add a forward slash here ---------^
                        }
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Location: ' . $home_row['Location'] . '</h5>';
                        // You can add more details here as needed
                        echo '<a href="details.php?id=' . $home_row['id'] . '" class="btn btn-primary">Home Details</a>';
                        echo '<a href="edit_home.php?id=' . $home_row['id'] . '" class="btn btn-success" style="margin-left: 20px;"><i class="fa fa-pen-to-square"></i></a>';
                        echo '<a href="delete_home.php?id=' . $home_row['id'] . '" class="btn btn-danger delete-button" style="margin-left: 20px;"><i class="fa fa-trash"></i></a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                ?>
            </div>

        </div>
    </div>

    <!--All home listings-->
    <?php
    if ($All_homes_result != null) {
        echo '<div class="row mt-5">';
        echo '<div class="col-md-12">';
        echo '<h2 class="text-center">All Database Homes</h2>';
        echo '<div class="row">';
        while ($home_row = $All_homes_result->fetch_assoc()) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            if ($home_row['Picture'] == null || $home_row['Picture'] == '') {
                // No image available
            } else {
                echo "<img src='media/homes/" . $home_row['Picture'] . "' class='card-img-top' style='height: 200px;' />";
                // Add a forward slash here ---------^
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Location: ' . $home_row['Location'] . '</h5>';
            // You can add more details here as needed
            echo '<a href="details.php?id=' . $home_row['id'] . '" class="btn btn-primary">Home Details</a>';
            echo '<a href="edit_home.php?id=' . $home_row['id'] . '" class="btn btn-success" style="margin-left: 20px;"><i class="fa fa-pen-to-square"></i></a>';
            echo '<a href="delete_home.php?id=' . $home_row['id'] . '" class="btn btn-danger delete-button" style="margin-left: 20px;"><i class="fa fa-trash"></i></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }
    ?>

    <!-- All users listings -->
    <?php
    $user_my_nig = false;
    if ($All_users_result != null && $user_my_nig!=true) {
        echo '<div class="container mt-5">';
        echo '<h2 class="text-center mb-4">All Users</h2>';
        echo '<div class="row">';

        while ($user_row = $All_users_result->fetch_assoc()) {
            if ($user_row['Name'] == $username) {
                $user_my_nig = true; // The user's profile is found
                continue; // Skip displaying the logged-in user's profile
            }
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            if ($user_row['Profile Picture'] == null || $user_row['Profile Picture'] == '') {
                // No image available
            } else {
                // Maintain aspect ratio with max-height style
                echo '<div class="text-center" style="max-height: 200px; overflow: hidden;">';
                echo '<img src="media/profiles/' . $user_row['Profile Picture'] . '" class="card-img-top img-fluid" style="max-width: 70%; height: 70%; object-fit: cover;" />';
                echo '</div>';
            }
            echo '<div class="card-body text-center">';
            echo '<h5 class="card-title">User: ' . $user_row['Name'] . '</h5>';
            // You can add more user details here as needed
            if($user_row['Role']!='Admin')
            {
                echo '<a href="make_admin.php?id=' . $user_row['id'] . '" class="btn btn-primary">Make Admin</a>';
            }
            else if($user_row['Role']='Admin')
            {
                echo '<a href="remove_admin.php?id=' . $user_row['id'] . '" class="btn btn-primary">Remove Admin</a>';
            }
            echo '<a href="edit_profile_admin.php?id=' . $user_row['id'] . '" class="btn btn-success mr-2" style="margin-left: 20px;"><i class="fas fa-edit"></i></a>';
            echo '<a href="delete_profile_admin.php?id=' . $user_row['id'] . '" class="btn btn-danger ml-2 delete-button" style="margin-left: 20px;"><i class="fas fa-trash"></i></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>
</div>

    <!-- Include the footer -->
    <?php include('footer.php'); ?>
