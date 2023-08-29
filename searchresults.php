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

<div class="homes-list">
    <h2>Search Results</h2>
    <ul>
        <?php
        if (!empty($results)) {
            foreach ($results as $row) {
                echo "<li>";
                if ($row['Picture']) {
                    echo "<img src='media/" . $row['Picture'] . "' style='width:100px;height:auto;' />";
                }
                echo "<br>";
                echo "Location: " . $row['Location'] . "<br>";
                echo "Price: " . $row['Price'] . "<br>";
                echo "Owner: " . $row['Owner'] . "<br>";
                echo "Rooms: " . $row['Rooms'] . "<br>";
                echo "Bathrooms: " . $row['Bathrooms'] . "<br>";
                echo "Floors: " . $row['Floors'] . "<br>";
                echo "Area: " . $row['Area'] . "<br>";
                echo "Contact: " . $row['Contact'] . "<br>";
                echo "</li>";
            }
        } else {
            echo "<p>No results found.</p>";
        }
        ?>
    </ul>
</div>

<?php
// Include the footer
include('footer.php');
?>
