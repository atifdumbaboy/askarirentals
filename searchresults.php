<?php
session_start();
include_once('connection.php');

// Get search attribute and query from POST
$searchAttribute = $_POST['attribute'];
$searchQuery = $_POST['search'];

// Sanitize inputs to prevent SQL injection
$searchAttribute = mysqli_real_escape_string($mysqli, $searchAttribute);
$searchQuery = mysqli_real_escape_string($mysqli, $searchQuery);

// Generate SQL query based on the search attribute and query
$searchSql = "SELECT * FROM homes WHERE $searchAttribute LIKE '%$searchQuery%'";

// Execute search query
$searchResult = $mysqli->query($searchSql);

// Store search results in a variable for display
$results = [];

if ($searchResult->num_rows > 0) {
    while ($row = $searchResult->fetch_assoc()) {
        $results[] = $row;
    }
}

// Include the header
include('header.php');
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="searchresults.php" method="POST" class="form-inline">
                <input type="hidden" name="attribute" value="<?php echo $searchAttribute; ?>">
                <select name="attribute" class="form-control mr-2">
                    <option value="Location" <?php echo ($searchAttribute === 'Location') ? 'selected' : ''; ?>>Location</option>
                    <option value="Price" <?php echo ($searchAttribute === 'Price') ? 'selected' : ''; ?>>Price</option>
                    <option value="Owner" <?php echo ($searchAttribute === 'Owner') ? 'selected' : ''; ?>>Owner</option>
                    <option value="Rooms" <?php echo ($searchAttribute === 'Rooms') ? 'selected' : ''; ?>>Rooms</option>
                    <option value="Bathrooms" <?php echo ($searchAttribute === 'Bathrooms') ? 'selected' : ''; ?>>Bathrooms</option>
                    <option value="Floors" <?php echo ($searchAttribute === 'Floors') ? 'selected' : ''; ?>>Floors</option>
                    <option value="Area" <?php echo ($searchAttribute === 'Area') ? 'selected' : ''; ?>>Area</option>
                    <option value="Contact" <?php echo ($searchAttribute === 'Contact') ? 'selected' : ''; ?>>Contact</option>
                </select>
                <input type="text" name="search" placeholder="Search by attribute" class="form-control mr-2" value="<?php echo $searchQuery; ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</div>

<div class="container mt-4 min-vh-100">
    <h2>Search Results</h2>
    <div class="row">
        <?php
        if (!empty($results)) {
            foreach ($results as $row) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card">';
                if ($row['Picture']) {
                    echo "<img src='media/" . $row['Picture'] . "' class='card-img-top' style='height: 200px;' />";
                }
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Location: ' . $row['Location'] . '</h5>';
                echo '<p>Price: ' . $row['Price'] . '</p>';
                echo '<a href="details.php?id=' . $row['id'] . '" class="btn btn-primary">More Details</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="col-md-12">';
            echo '<p class="text-center">No results found.</p>';
            echo '</div>';
        }
        ?>
    </div>
</div>


<?php
// Include the footer
include('footer.php');
?>
