<?php
include_once('connection.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to a login page or display an error message
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$message = '';

// Check if an ID is passed via the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id']; // Retrieve the user's ID from the URL parameter

    // Query the user's information based on the ID
    $userQuery = "SELECT * FROM users WHERE id='$userId'";
    $userResult = $mysqli->query($userQuery);

    if ($userResult->num_rows > 0) {
        // User with the provided ID found
        $userData = $userResult->fetch_assoc();

        // Check if the user wants to update the profile
        if (isset($_POST['update'])) {
            $newPassword = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Check if passwords match, and the password field is not empty
            if (!empty($newPassword) && $newPassword !== $confirmPassword) {
                $message = "Passwords do not match.";
            } else {
                // Hash the new password if it's not empty
                if (!empty($newPassword)) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                }

                // Check if a new profile picture is uploaded
                if (!empty($_FILES['profile_picture']['name'])) {
                    // Handle profile picture upload
                    $profilePictureTmp = $_FILES['profile_picture']['tmp_name'];
                    $profilePictureName = $userData['Name'] . "_" . time() . ".jpg"; // Unique name based on "Name" column and timestamp
                    $targetDirectory = "media/profiles/";
                    $profilePicturePath = $targetDirectory . $profilePictureName;

                    // Delete the old profile picture if it exists
                    if (!empty($userData['Profile Picture'])) {
                        $oldProfilePicturePath = $targetDirectory . $userData['Profile Picture'];
                        if (file_exists($oldProfilePicturePath)) {
                            unlink($oldProfilePicturePath); // Delete the old file
                        }
                    }

                    if (move_uploaded_file($profilePictureTmp, $profilePicturePath)) {
                        // Update the user's profile with the new password and profile picture
                        if (!empty($newPassword)) {
                            $updateQuery = "UPDATE users SET Password='$hashedPassword', `Profile Picture`='$profilePictureName' WHERE id='$userId'";
                        } else {
                            $updateQuery = "UPDATE users SET `Profile Picture`='$profilePictureName' WHERE id='$userId'";
                        }

                        if ($mysqli->query($updateQuery)) {
                            header("Location: dashboard.php");
                        } else {
                            $message = "Error updating profile: " . $mysqli->error;
                        }
                    } else {
                        $message = "Error moving the uploaded profile picture.";
                    }
                } else {
                    // Update the user's profile with the new password (if provided)
                    if (!empty($newPassword)) {
                        $updateQuery = "UPDATE users SET Password='$hashedPassword' WHERE id='$userId'";
                        if ($mysqli->query($updateQuery)) {
                            $message = "Profile updated successfully. Redirecting to Dashboard";
                            header("Location: dashboard.php");
                        } else {
                            $message = "Error updating profile: " . $mysqli->error;
                        }
                    } else {
                        // No new password or profile picture provided
                        $message = "No changes made to the profile.";
                    }
                }
            }
        }
    } else {
        // User with the provided ID not found
        $message = "User not found.";
    }
} else {
    // No ID provided in the URL
    $message = "No user ID provided.";
}
?>

<?php // Include the header
include('header.php');
?>

<div class="container mt-5 min-vh-100">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Edit Profile</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="centered-form">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Display the current details in the form -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $userData['Name']; ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm new password">
                    </div>
                    <!-- Display the current profile picture -->
                    <div class="form-group">
                        <label for="currentPicture">Current Profile Picture:</label>
                        <?php if (!empty($userData['Profile Picture'])): ?>
                            <img src="media/profiles/<?php echo $userData['Profile Picture']; ?>" class="img-fluid" style="max-height: 200px;" alt="Current Profile Picture">
                        <?php else: ?>
                            <p>No profile picture available</p>
                        <?php endif; ?>
                    </div>
                    <!-- Allow the user to upload a new profile picture -->
                    <div class="form-group">
                        <label for="profile_picture">Upload New Profile Picture (optional):</label>
                        <input type="file" class="form-control" name="profile_picture" accept="image/*">
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-primary" name="update" value="Update Profile">
                    </div>
                </form>
                <p class="text-center"><?php echo isset($message) ? $message : ''; ?></p>
            </div>
        </div>
    </div>
</div>

<?php // Include the footer
include('footer.php');
?>
