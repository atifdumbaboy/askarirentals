<?php
session_start();
include_once('connection.php');
include_once('header.php');
?>


<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f7f7f7;
}

.container {
    max-width: 960px;
    margin: 0 auto;
    padding: 20px;
}

.details-box {
    border: 1px solid #ccc;
    padding: 20px;
    text-align: center;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.details-box h2 {
    margin-top: 0;
    color: #333;
}

.details-image {
    max-width: 100%;
    display: block;
    margin: 0 auto;
}

.details-content {
    margin-top: 20px;
    text-align: left;
}

.details-content p {
    margin: 10px 0;
}

.details-footer {
    margin-top: 20px;
    text-align: center;
}

.details-footer a {
    color: #007bff;
    text-decoration: none;
}

.container {
    max-width: 960px;
    margin: 0 auto;
    padding: 20px;
    display: flex; /* Use flexbox to align the details box to the right */
    justify-content: center;
    align-items: flex-start;
}

.details-container {
    flex: 1; /* Expand to fill available space */
    max-width: 600px;
    padding: 20px;
    border: 1px solid #ccc;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.details-image {
    max-width: 100%;
    display: block;
    margin: 0 auto;
    border: 1px solid #ccc;
    padding: 5px;
}

/* Media Queries */
@media (max-width: 768px) {
    .container {
        padding: 10px;
    }
}

</style>

<?php
// Get the home ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $homeId = $_GET['id'];

    // Fetch the home details based on the ID
    $sql = "SELECT * FROM homes WHERE id = $homeId";
    $result = $mysqli->query($sql);
    $home = $result->fetch_assoc();
    
    if ($home) {
        echo "<div class='container'>";
        echo "<div class='details-container'>";
        
        // Display the detailed information about the home
        echo "<div class='details-content'>";
        echo "<h2>Home Details</h2>";
        echo "<img src='media/" . $home['Picture'] . "' class='details-image' />";
        echo "<p><strong>Location:</strong> " . $home['Location'] . "</p>";
        echo "<p><strong>Price:</strong> " . $home['Price'] . "</p>";
        echo "<p><strong>Owner:</strong> " . $home['Owner'] . "</p>";
        echo "<p><strong>Rooms:</strong> " . $home['Rooms'] . "</p>";
        echo "<p><strong>Bathrooms:</strong> " . $home['Bathrooms'] . "</p>";
        echo "<p><strong>Floors:</strong> " . $home['Floors'] . "</p>";
        echo "<p><strong>Area:</strong> " . $home['Area'] . "</p>";
        echo "<p><strong>Contact:</strong> " . $home['Contact'] . "</p>";
        echo "</div>";
    
        echo "</div>"; // Close details-container
        echo "</div>"; // Close container
    } else {
        echo "Home not found.";
    }
}
include_once('footer.php');
?>
