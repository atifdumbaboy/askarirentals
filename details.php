<?php
session_start();
include_once('connection.php');
include_once('header.php');
?>

<style>
    /* Custom CSS to center content vertically */
    .center-vertically {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 100vh; /* Ensure the content takes at least the full viewport height */
    }

    /* Additional custom styling for card */
    .details-box {
        padding: 20px;
        text-align: center;
        background-color: #fff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container-fluid center-vertically">
    <div class="container">
        <?php
        // Get the home ID from the URL
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $homeId = $_GET['id'];

            // Fetch the home details based on the ID
            $sql = "SELECT * FROM homes WHERE id = $homeId";
            $result = $mysqli->query($sql);
            $home = $result->fetch_assoc();

            if ($home) {
                // Display the home image to the left
                echo "<div class='row'>";
                echo "<div class='col-md-6'>";
                echo "<img src='media/" . $home['Picture'] . "' class='img-fluid details-image' />";
                echo "</div>";

                // Display the detailed information about the home to the right
                echo "<div class='col-md-6'>";
                echo "<div class='card details-box'>";
                echo "<div class='card-body'>";
                echo "<h2 class='card-title'>Home Details</h2>";
                echo "<p><strong>Location:</strong> " . $home['Location'] . "</p>";
                echo "<p><strong>Price:</strong> " . $home['Price'] . "</p>";
                echo "<p><strong>Owner:</strong> " . $home['Owner'] . "</p>";
                echo "<p><strong>Rooms:</strong> " . $home['Rooms'] . "</p>";
                echo "<p><strong>Bathrooms:</strong> " . $home['Bathrooms'] . "</p>";
                echo "<p><strong>Floors:</strong> " . $home['Floors'] . "</p>";
                echo "<p><strong>Area:</strong> " . $home['Area'] . "</p>";
                echo "<p><strong>Contact:</strong> " . $home['Contact'] . "</p>";
                echo "</div>";
                echo "</div>"; // Close details-box
                echo "</div>"; // Close column

                echo "</div>"; // Close row
            } else {
                echo "<div class='alert alert-danger'>Home not found.</div>";
            }
        }
        ?>
    </div>
</div>

<?php
include_once('footer.php');
?>
