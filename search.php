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


<div class="search-bar" style="text-align: center; margin-top: 20px;">
    <form action="" method="GET" style="display: inline-block; background-color: #f2f2f2; padding: 10px; border-radius: 8px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);">
        <select name="attribute" style="padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-right: 5px;">
            <option value="Location">Location</option>
            <option value="Price">Price</option>
            <option value="Owner">Owner</option>
            <option value="Rooms">Rooms</option>
            <option value="Bathrooms">Bathrooms</option>
            <option value="Floors">Floors</option>
            <option value="Area">Area</option>
            <option value="Contact">Contact</option>
        </select>
        <input type="text" name="search" placeholder="Search by attribute" style="padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-right: 5px;">
        <button type="submit" style="background-color: #007bff; color: #fff; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Search</button>
    </form>
</div>


<div class="homes-list">
    <?php
    if (isset($searchResult)) {
        echo "<h2>Search Results</h2>";
        if ($searchResult->num_rows > 0) {
            echo "<ul>";
            while ($row = $searchResult->fetch_assoc()) {
                echo "<li>";
                if ($row['Picture'] == null || $row['Picture'] == '') {
                    
                } else {
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
            echo "</ul>";
        } else {
            echo "<p>No results found.</p>";
        }
    }
    ?>
</div>

<?php // Include the footer
include('footer.php');
?>