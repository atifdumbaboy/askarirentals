<?php
session_start();
include_once('connection.php');

// Initialize sorting variables
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : ''; // Get the selected sorting option
$orderBy = isset($_GET['order']) ? $_GET['order'] : 'ASC'; // Default sorting order

// Construct the SQL query based on sorting options
$sql = "SELECT * FROM homes";

if (!empty($sortBy)) {
    $sql .= " ORDER BY $sortBy $orderBy";
}

// Execute the query
$result = $mysqli->query($sql);
?>

<?php // Include the header
include('header.php');
?>
<style>
    /* Custom styling for select elements */
    .custom-select {
        padding: 8px; /* Adjust padding as needed */
        font-size: 16px; /* Adjust font size as needed */
        border: 1px solid #ccc; /* Add a border */
        border-radius: 4px; /* Add rounded corners */
        width: 200px; /* Set the width as needed */
        margin-bottom: none;
    }

    /* Style the selected option */
    .custom-select option:checked {
        background-color: #007bff; /* Background color for selected option */
        color: #fff; /* Text color for selected option */
    }

</style>

<!--Slider implementation lessssssssssssgoooooooooooooooooooooooooooo boiiiiiiiiiiiiiiiii-------->
<div id="imageCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#imageCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#imageCarousel" data-slide-to="1"></li>
        <li data-target="#imageCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Slides --> 
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="media/statics/home-slider-1.png" alt="Image 1" class="d-block w-100">
        </div>
        <div class="carousel-item">
            <img src="media/statics/home-slider-2.png" alt="Image 2" class="d-block w-100">
        </div>
        <div class="carousel-item">
            <img src="media/statics/home-slider-3.png" alt="Image 3" class="d-block w-100">
        </div>
        <!-- Add more slides with different images -->
    </div>

    <!-- Controls -->
    <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="container mt-4 text-center">
    <form method="GET" action="" class="sorting-form">
        <label for="sort">Sort By:</label>
        <select name="sort" id="sort" class="custom-select sorting-select">
            <option value="">Attribute</option>
            <option value="Location">Location</option>
            <option value="Price">Price</option>
            <option value="Rooms">Rooms</option>
            <option value="Floors">Floors</option>
            <option value="Bathrooms">Bathrooms</option>
        </select>
        <label for="order">Order:</label>
        <select name="order" id="order" class="custom-select sorting-select">
            <option value="ASC">Ascending</option>
            <option value="DESC">Descending</option>
        </select>
        <button type="submit" class="btn btn-primary">Sort</button>
    </form>
</div>

<!-- Add a form for selecting sorting options -->
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
                echo "<img src='media/homes/" . $row['Picture'] . "' class='card-img-top' style='height: 200px;' />";
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Location: ' . $row['Location'] . '</h5>';
            echo '<a href="details.php?id=' . $row['id'] . '" class="btn btn-primary">Home Details</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
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
        echo '<h3>Homes in ' . $location . '</h3>';
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
                echo "<img src='media/homes/" . $homeRow['Picture'] . "' class='card-img-top' style='height: 200px;' />";
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
