<?php
session_start();
include_once('connection.php');

// fetching queries
$sql = "SELECT * FROM homes";

//storage
$result = $mysqli->query($sql);
?>

<?php // Include the header
include('header.php');
?>

<!--Search baaaaaaaaaar-->
<div class="search-bar" style="text-align: center; margin-top: 20px;">
    <form action="searchresults.php" method="POST" style="display: inline-block; background-color: #f2f2f2; padding: 10px; border-radius: 8px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);">
        <input type="hidden" name="attribute" value="Location"> <!-- Default attribute -->
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
    <h2>All Homes</h2>
    <ul>
        <?php
        // Loop through the results and display each home
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
            if ($row['Picture'] == null || $row['Picture'] == '') {
                // No image available
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
            echo "<a href='details.php?id=" . $row['id'] . "'>More Details</a>"; // Use $row['ID'] here
            echo "</li>";
        }
        ?>
    </ul>
</div>
<?php
// displaying homes by location now
$sql = "SELECT * FROM homes";
$result = $mysqli->query($sql);

// Grouping homes by location
$homesByLocation = array();
while ($row = $result->fetch_assoc()) {
    $location = $row['Location'];
    if (!isset($homesByLocation[$location])) {
        $homesByLocation[$location] = array();
    }
    $homesByLocation[$location][] = $row;
}
?>
<div class="homes-list">
    <?php
    foreach ($homesByLocation as $location => $locationHomes) {
        echo "<h2>Homes in $location</h2>";
        echo "<ul>";
        foreach ($locationHomes as $home) {
            echo "<li>";
            if ($home['Picture'] == null || $home['Picture'] == '') {
                // No image available
            } else {
                echo "<img src='media/" . $home['Picture'] . "' style='width:100px;height:auto;' />";
            }
            echo "<br>";
            echo "Location: " . $home['Location'] . "<br>";
            echo "Price: " . $home['Price'] . "<br>";
            echo "Owner: " . $home['Owner'] . "<br>";
            echo "Rooms: " . $home['Rooms'] . "<br>";
            echo "Bathrooms: " . $home['Bathrooms'] . "<br>";
            echo "Floors: " . $home['Floors'] . "<br>";
            echo "Area: " . $home['Area'] . "<br>";
            echo "Contact: " . $home['Contact'] . "<br>";
            echo "<a href='details.php?id=" . $home['id'] . "'>More Details</a>"; // Use $row['ID'] here
            echo "</li>";
        }
        echo "</ul>";
    }
    ?>
</div>




<?php // Include the footer
include('footer.php');
?>
