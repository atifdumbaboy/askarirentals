<?php
include_once('connection.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to a login page or display an error message
    header("Location: login.php");
    exit();
}

// Check if an 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $home_id = $_GET['id'];

    // Query to retrieve the home details based on the provided 'id'
    $query = "SELECT * FROM homes WHERE id='$home_id'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $home_data = $result->fetch_assoc();

        if (isset($_POST['update'])) {
            // Get the values from the form
            $newLocation = $_POST['Location'];
            $newPrice = $_POST['Price'];
            $newContact = $_POST['Contact'];
            $newBathrooms = $_POST['Bathrooms'];
            $newRooms = $_POST['Rooms'];
            $newFloors = $_POST['Floors'];
            $newArea = $_POST['Area'];

            // Check if a new image is uploaded
            if (!empty($_FILES['fileToUpload']['name'])) {
                // Delete the old image
                if (!empty($home_data['Picture'])) {
                    unlink("media/homes/" . $home_data['Picture']);
                }

                // Upload the new image
                $file_tmp = $_FILES['fileToUpload']['tmp_name'];
                $file_name = $_FILES['fileToUpload']['name'];
                $target_directory = "media/homes/";
                $target_path = $target_directory . $file_name;

                if (move_uploaded_file($file_tmp, $target_path)) {
                    $newPicture = $file_name;
                } else {
                    $newPicture = ''; // Keep the old image if the upload fails
                }
            } else {
                // Keep the old image if no new image is uploaded
                $newPicture = $home_data['Picture'];
            }

            // Update the home details in the database
            $update_query = "UPDATE homes SET Location='$newLocation', Price='$newPrice', Contact='$newContact', 
                             Bathrooms='$newBathrooms', Rooms='$newRooms', Floors='$newFloors', Area='$newArea', 
                             Picture='$newPicture' WHERE id='$home_id'";
            if ($mysqli->query($update_query)) {
                // Handle the slider images
                for ($i = 1; $i <= 3; $i++) {
                    $fileInputName = "sliderFileToUpload$i";

                    // Check if a new slider image is uploaded
                    if (!empty($_FILES[$fileInputName]['name'])) {
                        // Delete the old slider image
                        if (!empty($home_data["SliderImage$i"])) {
                            unlink("media/homes/sliders/" . $home_data["SliderImage$i"]);
                        }

                        // Upload the new slider image
                        $slider_file_tmp = $_FILES[$fileInputName]['tmp_name'];
                        $slider_file_name = $_FILES[$fileInputName]['name'];
                        $slider_target_directory = "media/homes/sliders/";
                        $slider_target_path = $slider_target_directory . $slider_file_name;

                        if (move_uploaded_file($slider_file_tmp, $slider_target_path)) {
                            $newSliderImage = $slider_file_name;
                        } else {
                            $newSliderImage = ''; // Keep the old slider image if the upload fails
                        }

                        // Update the corresponding SliderImage column
                        $sliderImageColumn = "SliderImage$i";
                        $updateSliderQuery = "UPDATE homes SET $sliderImageColumn='$newSliderImage' WHERE id='$home_id'";
                        if ($mysqli->query($updateSliderQuery)) {
                            // Slider image update successful
                        } else {
                            echo "Error updating slider image $i: " . $mysqli->error;
                        }
                    }
                }

                // Redirect to the dashboard or another page after successful update
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error updating home details: " . $mysqli->error;
            }
        }
    } else {
        // Home with the provided ID does not exist
        echo "Home not found.";
    }
} else {
    // No 'id' parameter provided in the URL
    echo "Invalid request.";
}

// Include the header
include('header.php');
?>

<div class="container mt-5 min-vh-100">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Edit Home</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="centered-form">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Display the current details in the form -->
                    <div class="form-group">
                        <label for="Location"><i class="fas fa-map-marker-alt"></i> Location</label>
                        <input type="text" class="form-control" name="Location" placeholder="Location" value="<?php echo $home_data['Location']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Price"><i class="fas fa-hand-holding-dollar"></i> Price</label>
                        <input type="number" class="form-control" name="Price" placeholder="Price" value="<?php echo $home_data['Price']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Contact"><i class="fas fa-phone"></i> Contact No</label>
                        <input type="text" class="form-control" name="Contact" placeholder="Contact No" value="<?php echo $home_data['Contact'];?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Bathrooms"><i class="fas fa-bath"></i> Number of Bathrooms</label>
                        <input type="number" class="form-control" name="Bathrooms" placeholder="Number of Bathrooms?" value="<?php echo $home_data['Bathrooms']; ?>" required>
                    </div>
                    <div class "form-group">
                    <label for="Rooms"><i class="fas fa-bed"></i> Number of Rooms</label>
                    <input type="number" class="form-control" name="Rooms" placeholder="Number of Rooms?" value="<?php echo $home_data['Rooms']; ?>" required>
            </div>
            <div class="form-group">
                <label for="Floors"><i class="fas fa-layer-group"></i> Number of Floors</label>
                <input type="number" class="form-control" name="Floors" placeholder="Number of Floors?" value="<?php echo $home_data['Floors']; ?>" required>
            </div>
            <div class="form-group">
                <label for="Area"><i class="fas fa-home"></i> Area of House</label>
                <input type="text" class="form-control" name="Area" placeholder="Area of House?" value="<?php echo $home_data['Area']; ?>" required>
            </div>
            <!-- Display the current image -->
            <div class="form-group">
                <label for="currentPicture">Current Picture:</label>
                <?php if (!empty($home_data['Picture'])): ?>
                    <img src="media/homes/<?php echo $home_data['Picture']; ?>" class="img-fluid" style="max-height: 200px;" alt="Current Picture">
                <?php else: ?>
                    <p>No image available</p>
                <?php endif; ?>
            </div>
            <!-- Allow the user to upload a new image -->
            <div class="form-group">
                <label for="fileToUpload">Upload New Picture (optional):</label>
                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
            </div>
            <!-- Display the current slider images -->
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div class="form-group">
                    <label for="currentSliderImage<?= $i ?>">Current Slider Image <?= $i ?>:</label>
                    <?php if (!empty($home_data["SliderImage$i"])): ?>
                        <img src="media/homes/sliders/<?php echo $home_data["SliderImage$i"]; ?>" class="img-fluid" style="max-height: 200px;" alt="Current Slider Image <?= $i ?>">
                    <?php else: ?>
                        <p>No image available</p>
                    <?php endif; ?>
                </div>
                <!-- Allow the user to upload a new slider image (optional) -->
                <div class="form-group">
                    <label for="sliderFileToUpload<?= $i ?>">Upload New Slider Image <?= $i ?> (optional):</label>
                    <input type="file" class="form-control" name="sliderFileToUpload<?= $i ?>" id="sliderFileToUpload<?= $i ?>">
                </div>
            <?php endfor; ?>
            <div class="form-group text-center">
                <input type="submit" class="btn btn-primary" name="update" value="Update">
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<?php // Include the footer
include('footer.php');
?>
