<?php
include_once('connection.php');
$message = ''; // Initialize an empty message

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the username is already in use
    $check_query = "SELECT * FROM users WHERE Name='$name'";
    $check_result = $mysqli->query($check_query);

    if ($check_result->num_rows > 0) {
        $message = "Username already in use.";
    } elseif ($password == $confirm_password) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Handle profile picture upload
        $profile_picture_name = ''; // Initialize an empty variable to store the image name

        if (isset($_FILES['profile_picture'])) {
            $profile_picture_tmp = $_FILES['profile_picture']['tmp_name'];
            $profile_picture_name = $_FILES['profile_picture']['name'];
            $target_directory = "media/profiles/";

            // Create a unique name for the uploaded image
            $profile_picture_name = uniqid() . '_' . $profile_picture_name;

            $target_path = $target_directory . $profile_picture_name;

            if (move_uploaded_file($profile_picture_tmp, $target_path)) {
                // Insert data into the database
                $sql = "INSERT INTO users (Name, Password, `Profile Picture`) 
                        VALUES ('$name', '$hashed_password', '$profile_picture_name')";

                if ($mysqli->query($sql)) {
                    // Redirect the user to the appropriate page based on the session attribute 'homeId'
                    session_start();

                    if (isset($_SESSION['homeId'])) {
                        $homeId = $_SESSION['homeId'];
                        header("Location: login.php?id=$homeId");
                    } else {
                        header("Location: dashboard.php");
                    }
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                }
            } else {
                echo "Error moving the uploaded profile picture.";
            }
        }
    } else {
        $message = "Passwords do not match.";
    }
}

// Check if 'homeId' is present in the URL
if (isset($_GET['homeId'])) {
    // If it is, store it in a session variable
    session_start();
    $_SESSION['homeId'] = $_GET['homeId'];
}

?>

<?php // Include the header
include('header.php');
?>

<div class="container-fluid min-vh-100">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Signup Form</div>
                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" placeholder="Confirm your password" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" value="Submit" name="submit">
                        </div>
                        <div class="form-group">
                            <a href="login.php<?php echo isset($_SESSION['homeId']) ? '?homeId=' . $_SESSION['homeId'] : ''; ?>">Already have an account?</a>
                        </div>
                    </form>
                    <p class="text-center"><?php echo $message; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php // Include the footer
include('footer.php');
?>
