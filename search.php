<?php
include_once('connection.php');

// Initialize variables
$searchQuery = "";
$searchAttribute = "Location"; // Default attribute

// Handle search form submission
if (isset($_GET['search'])) {
    if (isset($_GET['attribute'])) {
        $searchAttribute = $_GET['attribute'];
    }

    $searchQuery = $_GET['search'];

    // Validate and sanitize inputs to prevent SQL injection
    $searchAttribute = mysqli_real_escape_string($mysqli, $searchAttribute);
    $searchQuery = mysqli_real_escape_string($mysqli, $searchQuery);

    // Determine if the search query is numeric
    $isNumericQuery = is_numeric($searchQuery);

    if ($isNumericQuery) {
        // Use exact match for numeric queries
        $searchSql = "SELECT * FROM homes WHERE $searchAttribute = '$searchQuery'";
    } else {
        // Use LIKE for non-numeric queries
        $searchSql = "SELECT * FROM homes WHERE $searchAttribute LIKE '%$searchQuery%'";
    }

    // Execute search query
    $searchResult = $mysqli->query($searchSql);
}
?>

<?php // Include the header
include('header.php');
?>

<div class="container mt-4">
    <form action="" method="GET" class="form-inline justify-content-center">
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

<div class="container mt-4 min-vh-100">
    <?php
    if (isset($searchResult)) {
        if ($searchResult->num_rows > 0) {
            echo "<h2>Search Results</h2>";
            echo '<div class="row">';
            while ($row = $searchResult->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card">';
                if ($row['Picture'] != null && $row['Picture'] != '') {
                    echo "<img src='media/homes/" . $row['Picture'] . "' class='card-img-top' alt='Home Image' style='height: 200px;'>";
                }
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Location: ' . $row['Location'] . '</h5>';
                echo '<p>Price: ' . $row['Price'] . '</p>';
                echo '<p>Owner: ' . $row['Owner'] . '</p>';
                echo '<p>Rooms: ' . $row['Rooms'] . '</p>';
                echo '<p>Bathrooms: ' . $row['Bathrooms'] . '</p>';
                echo '<p>Floors: ' . $row['Floors'] . '</p>';
                echo '<p>Area: ' . $row['Area'] . '</p>';
                echo '<p>Contact: ' . $row['Contact'] . '</p>';
                echo '<a href="details.php?id=' . $row['id'] . '" class="btn btn-primary">Home Details</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>'; // Close the row
        } else {
            echo "<h2>No results found.</h2>";
            // Display a search emoji when no search has been performed
            echo '<i class="far fa-frown display-4 mt-3 text-muted"></i>';
        }
    } else {
        // Display a search emoji when no search has been performed
        echo '<div class="text-center mt-5">';
        echo '<i class="far fa-smile display-4 text-muted"></i>';
        echo '<h2 class="text-muted">Start your search above</h2>';
        echo '</div>';
    }
    ?>
</div>

<?php // Include the footer
include('footer.php');
?>
