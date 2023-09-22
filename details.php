<?php
session_start();
include_once('connection.php');
include_once('header.php');
?>

<style>
    /* Add margin to home details and related homes */
    .home-details {
        margin-top: 80px;
        margin-bottom: 80px;
    }

    .related-homes {
        margin-top: 80px;
        margin-bottom: 80px;
    }
</style>

<div class="container-fluid center-vertically">
    <div class="container">
        <?php
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $homeId = $_GET['id'];
            $sql = "SELECT * FROM homes WHERE id = $homeId";
            $result = $mysqli->query($sql);
            $home = $result->fetch_assoc();

            if ($home) {
                ?>
                <!-- Start Bootstrap Card for Home Details -->
                <div class="card home-details">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img src="media/homes/<?php echo $home['Picture']; ?>" class="img-fluid details-image" alt="Home Image">
                            </div>
                            <div class="col-md-6">
                                <h3><?php echo $home['Location']; ?></h3>
                                <p><i class="fas fa-bed"></i> <?php echo $home['Rooms']; ?> Bedrooms</p>
                                <p><i class="fas fa-map-marker-alt"></i> <?php echo $home['Location']; ?></p>
                                <p><i class="fa fa-hand-holding-dollar"></i> <?php echo $home['Price'].'pkr'; ?></p>
                                <p><i class="fa fa-user"></i> <?php echo $home['Owner']; ?></p>
                                <p><i class="fa fa-bathtub"></i> <?php echo $home['Bathrooms']; ?> Bathrooms</p>
                                <p><i class="fa fa-layer-group"></i> <?php echo $home['Floors']; ?> Floors</p>
                                <p><i class="fa fa-house"></i> <?php echo $home['Area']; ?></p>
                                <p><i class="fa fa-phone"></i> <?php echo $home['Contact']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Bootstrap Card for Home Details -->

                <!-- Related Homes Section -->
                <div class="related-homes">
                    <h2>Related Homes</h2>
                    <div class="row">
                        <?php
                        $relatedHomesSql = "SELECT * FROM homes WHERE Location = '" . $home['Location'] . "' AND id != $homeId LIMIT 6";
                        $relatedHomesResult = $mysqli->query($relatedHomesSql);

                        // Check if there are related homes
                        if ($relatedHomesResult->num_rows > 0) {
                            while ($relatedHome = $relatedHomesResult->fetch_assoc()) {
                                ?>
                                <div class="col-md-4 related-home">
                                    <img src="media/homes/<?php echo $relatedHome['Picture']; ?>" class="img-fluid" alt="Related Home Image">
                                    <p><strong>Location:</strong> <?php echo $relatedHome['Location']; ?></p>
                                    <p><strong>Price:</strong> <?php echo $relatedHome['Price']; ?></p>
                                    <a href="details.php?id=<?php echo $relatedHome['id']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                                <?php
                            }
                        } else {
                            // If no related homes are found, display three random ones
                            $randomHomesSql = "SELECT * FROM homes WHERE id != $homeId ORDER BY RAND() LIMIT 3";
                            $randomHomesResult = $mysqli->query($randomHomesSql);
                            while ($randomHome = $randomHomesResult->fetch_assoc()) {
                                ?>
                                <div class="col-md-4 related-home">
                                    <img src="media/homes/<?php echo $randomHome['Picture']; ?>" class="img-fluid" alt="Random Home Image">
                                    <p><strong>Location:</strong> <?php echo $randomHome['Location']; ?></p>
                                    <p><strong>Price:</strong> <?php echo $randomHome['Price']; ?></p>
                                    <a href="details.php?id=<?php echo $randomHome['id']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>

                </div>
                <!-- End Related Homes Section -->
                <?php
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
