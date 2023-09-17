<?php
session_start();
include_once('connection.php');

// Fetching queries
$sql = "SELECT * FROM homes";

// Storage
$result = $mysqli->query($sql);
?>

<?php // Include the header
include('header.php');
?>

<!-- Add space between header items and search bar -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="searchresults.php" method="POST" class="form-inline">
                <input type="hidden" name="attribute" value="Location"> <!-- Default attribute -->
                <select name="attribute" class="form-control mr-2">
                    <option value="Location">Location</option>
                    <option value="Price">Price</option>
                    <option value="Owner">Owner</option>
                    <option value="Rooms">Rooms</option>
                    <option value="Bathrooms">Bathrooms</option>
                    <option value="Floors">Floors</option>
                    <option value="Area">Area</option>
                    <option value="Contact">Contact</option>
                </select>
                <input type="text" name="search" placeholder="Search by attribute" class="form-control mr-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</div>

<!-- Homes list -->
<div class="container mt-4">
    <h2>All Homes</h2>
    <div class="row">
        <?php
        // Loop through the results and display each home
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            if ($row['Picture'] == null || $row['Picture'] == '') {
                // No image available
            } else {
                echo "<img src='media/" . $row['Picture'] . "' class='card-img-top' style='height: 200px;' />";
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Location: ' . $row['Location'] . '</h5>';
            echo '<a href="details.php?id=' . $row['id'] . '" class="btn btn-primary">More Details</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<!-- List homes by distinct locations -->
<div class="container mt-4">
    <?php
    // Query the database for distinct locations
    $distinctLocationsSql = "SELECT DISTINCT Location FROM homes";
    $distinctLocationsResult = $mysqli->query($distinctLocationsSql);

    while ($locationRow = $distinctLocationsResult->fetch_assoc()) {
        $location = $locationRow['Location'];
        echo '<div class="row mb-3">';
        echo '<div class="col-md-12">';
        echo '<h3>Location: ' . $location . '</h3>';
        echo '</div>';
        echo '</div>';

        echo '<div class="row">';

        // Query homes in the current location
        $homesInLocationSql = "SELECT * FROM homes WHERE Location = '$location'";
        $homesInLocationResult = $mysqli->query($homesInLocationSql);

        while ($homeRow = $homesInLocationResult->fetch_assoc()) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            if ($homeRow['Picture'] == null || $homeRow['Picture'] == '') {
                // No image available
            } else {
                echo "<img src='media/" . $homeRow['Picture'] . "' class='card-img-top' style='height: 200px;' />";
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Location: ' . $homeRow['Location'] . '</h5>';
            echo '<a href="details.php?id=' . $homeRow['id'] . '" class="btn btn-primary">More Details</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>'; // Close row
    }
    ?>
</div>

<?php // Include the footer
include('footer.php');
?>
