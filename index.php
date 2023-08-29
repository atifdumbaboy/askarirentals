<?php
include_once('connection.php');

// fetching queries
$sql = "SELECT * FROM homes";
$lahoresql = "SELECT * FROM homes WHERE Location='Lahore'";

//storage
$result = $mysqli->query($sql);
$lahore = $mysqli->query($lahoresql);
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
            echo "</li>";
        }
        ?>
    </ul>
    <h2>Homes in Lahore</h2>
    <ul>
        <?php
        // Loop through the results and display each home
        while ($row = $lahore->fetch_assoc()) {
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
            echo "</li>";
        }
        ?>
    </ul>
</div>

<?php // Include the footer
include('footer.php');
?>
