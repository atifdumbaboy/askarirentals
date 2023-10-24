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

        if (isset($_POST['upload'])) {
            // Set $home['Slider'] to not null
            $updateSliderQuery = "UPDATE homes SET Slider='not null' WHERE id='$home_id'";
            if ($mysqli->query($updateSliderQuery)) {
                for ($i = 1; $i <= 3; $i++) {
                    $fileInputName = "fileToUpload$i";

                    // Check if a new image is uploaded
                    if (!empty($_FILES[$fileInputName]['name'])) {
                        // Generate a unique filename based on owner, house id, and image number
                        $newFileName = $home_data['Owner'] . "_$home_id" . "_$i";

                        // Get the file extension
                        $fileExtension = pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION);

                        // Construct the target directory and path
                        $targetDirectory = "media/homes/sliders/";
                        $targetPath = $targetDirectory . $newFileName . "." . $fileExtension;

                        if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetPath)) {
                            // Update the corresponding SliderImage column
                            $sliderImageColumn = "SliderImage$i";
                            $updateQuery = "UPDATE homes SET $sliderImageColumn='$newFileName.$fileExtension' WHERE id='$home_id'";
                            if ($mysqli->query($updateQuery)) {
                                // Update successful
                                header("Location: details.php?id=$home_id"); // Redirect to details.
                            } else {
                                echo "Error updating slider image: " . $mysqli->error;
                            }
                        }
                    }
                }
            } else {
                echo "Error updating Slider: " . $mysqli->error;
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
            <h1>Add Slider Images</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="centered-form">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Allow the user to upload three slider images -->
                    <?php for ($i = 1; $i <= 3; $i++): ?>
                        <div class="form-group">
                            <label for="fileToUpload<?= $i ?>">Upload Slider Image <?= $i ?> (optional):</label>
                            <input type="file" class="form-control" name="fileToUpload<?= $i ?>" id="fileToUpload<?= $i ?>">
                        </div>
                    <?php endfor; ?>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-primary" name="upload" value="Upload Images">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php // Include the footer
include('footer.php');
?>
