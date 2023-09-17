<?php
include_once('connection.php');
$message = ''; // Initialize an empty message

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password == $confirm_password) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (Name, Password) VALUES ('$name', '$hashed_password')";
        if ($mysqli->query($sql)) {
            // Set the delay in seconds before redirection (e.g., 3 seconds)
            $delayInSeconds = 3;

            // Construct the Refresh header to redirect to the login page after the delay
            header("Refresh: {$delayInSeconds}; url=login.php");

            // Display a message to inform the user about the redirection
            $message = "Signup successful. Redirecting to the login page in {$delayInSeconds} seconds";

            // Do not exit here, let the rest of the HTML render
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    } else {
        $message = "Passwords do not match.";
    }
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
                    <form method="post" action="">
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
                            <input type="submit" class="btn btn-primary btn-block" value="Submit" name="submit">
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
