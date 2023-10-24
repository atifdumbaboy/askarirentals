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
     .related-home img {
         max-height: 200px; /* Adjust this value to your desired maximum height */
         width: auto; /* Maintain aspect ratio */
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
                        <?php if (isset($_SESSION['username'])) { ?>
                            <!-- Display Home Details for Logged-In Users -->
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <?php
                                    // Check if slider images are present based on $home['Slider']
                                    if ($home['Slider'] !== NULL) {
                                        // Main home image and slider images in the carousel
                                        ?>
                                        <div id="imageCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                                            <!-- Indicators -->
                                            <ol class="carousel-indicators">
                                                <li data-target="#imageCarousel" data-slide-to="0" class="active"></li>
                                                <?php
                                                $sliderImages = [$home['SliderImage1'], $home['SliderImage2'], $home['SliderImage3']];
                                                $sliderImages = array_filter($sliderImages, function ($image) {
                                                    return !empty($image);
                                                });
                                                if (count($sliderImages) >= 3) {
                                                    for ($i = 1; $i <= 3; $i++) {
                                                        ?>
                                                        <li data-target="#imageCarousel" data-slide-to="<?php echo $i; ?>"></li>
                                                    <?php }
                                                } else {
                                                    // If there are fewer than 3 slider images, use the total count
                                                    for ($i = 1; $i <= count($sliderImages); $i++) {
                                                        ?>
                                                        <li data-target="#imageCarousel" data-slide-to="<?php echo $i; ?>"></li>
                                                    <?php }
                                                }
                                                ?>
                                            </ol>

                                            <!-- Slides -->
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="media/homes/<?php echo $home['Picture']; ?>" alt="Home Image"
                                                         class="d-block w-100">
                                                </div>
                                                <?php
                                                if (count($sliderImages) >= 3) {
                                                    for ($i = 0; $i < 3; $i++) {
                                                        if (!empty($sliderImages[$i])) {
                                                            ?>
                                                            <div class="carousel-item">
                                                                <img src="media/homes/sliders/<?php echo $sliderImages[$i]; ?>"
                                                                     alt="Slider Image <?php echo $i + 1; ?>"
                                                                     class="d-block w-100">
                                                            </div>
                                                        <?php }
                                                    }
                                                } else {
                                                    // If there are fewer than 3 slider images, use the total count
                                                    for ($i = 0; $i < count($sliderImages); $i++) {
                                                        if (!empty($sliderImages[$i])) {
                                                            ?>
                                                            <div class="carousel-item">
                                                                <img src="media/homes/sliders/<?php echo $sliderImages[$i]; ?>"
                                                                     alt="Slider Image <?php echo $i + 1; ?>"
                                                                     class="d-block w-100">
                                                            </div>
                                                        <?php }
                                                    }
                                                }
                                                ?>
                                            </div>

                                            <!-- Controls -->
                                            <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" ariahidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" ariahidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    <?php } else {
                                        // If there are no slider images, show only the main image
                                        ?>
                                        <img src="media/homes/<?php echo $home['Picture']; ?>"
                                             class="img-fluid details-image" alt="Home Image">
                                    <?php } ?>
                                </div>
                                <div class="col-md-6">
                                    <h3><?php echo $home['Location']; ?></h3>
                                    <p><i class="fas fa-bed"></i> <?php echo $home['Rooms']; ?> Bedrooms</p>
                                    <p><i class="fas fa-map-marker-alt"></i> <?php echo $home['Location']; ?></p>
                                    <p><i class="fa fa-hand-holding-dollar"></i> <?php echo $home['Price'] . 'pkr'; ?></p>
                                    <p><i class="fa fa-user"></i> <?php echo $home['Owner']; ?></p>
                                    <p><i class="fa fa-bathtub"></i> <?php echo $home['Bathrooms']; ?> Bathrooms</p>
                                    <p><i class="fa fa-layer-group"></i> <?php echo $home['Floors']; ?> Floors</p>
                                    <p><i class="fa fa-home"></i> <?php echo $home['Area']; ?></p>
                                    <p><i class="fa fa-phone"></i> <?php echo $home['Contact']; ?></p>
                                    <?php
                                    if ($_SESSION['username'] == $home['Owner'] && $home['Slider'] === NULL) {
                                        echo '<a href="add_slider.php?id=' . $home['id'] . '" class="btn btn-primary">Add Slider Images</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <!-- Display Login Message and Buttons for Non-Logged-In Users -->
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-md-6 text-center">
                                        <img src="media/homes/<?php echo $home['Picture']; ?>"
                                             class="img-fluid details-image" alt="Home Image">
                                    </div>
                                    <div class="col-md-6">
                                        <h3><?php echo $home['Location']; ?></h3>
                                        <p><i class="fas fa-bed"></i> <?php echo $home['Rooms']; ?> Bedrooms</p>
                                        <p><i class="fas fa-map-marker-alt"></i> <?php echo $home['Location']; ?></p>
                                        <p><i class="fa fa-hand-holding-dollar"></i> <?php echo $home['Price'] . 'pkr'; ?></p>
                                        <p><i class="fa fa-user"></i> <?php echo $home['Owner']; ?></p>
                                        <a href="signup.php?homeId=<?php echo $homeId; ?>">Signup to View More Images and Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
                                    <img src="media/homes/<?php echo $relatedHome['Picture']; ?>" class="img-fluid related-home-image"
                                         alt="Related Home Image">
                                    <p><strong>Location:</strong> <?php echo $relatedHome['Location']; ?></p>
                                    <p><strong>Price:</strong> <?php echo $relatedHome['Price']; ?></p>
                                    <a href="details.php?id=<?php echo $relatedHome['id']; ?>"
                                       class="btn btn-primary">View Details</a>
                                </div>
                                <?php
                            }
                        } else {
                            // If no related homes are found, display three random ones
                            $randomHomesSql = "SELECT * FROM homes WHERE id != $homeId AND id != " . $home['id'] . " ORDER BY RAND() LIMIT 3";
                            $randomHomesResult = $mysqli->query($randomHomesSql);
                            while ($randomHome = $randomHomesResult->fetch_assoc()) {
                                ?>
                                <div class="col-md-4 related-home">
                                    <img src="media/homes/<?php echo $randomHome['Picture']; ?>" class="img-fluid related-home-image"
                                         alt="Random Home Image">
                                    <p><strong>Location:</strong> <?php echo $randomHome['Location']; ?></p>
                                    <p><strong>Price:</strong> <?php echo $randomHome['Price']; ?></p>
                                    <a href="details.php?id=<?php echo $randomHome['id']; ?>"
                                       class="btn btn-primary">View Details</a>
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
