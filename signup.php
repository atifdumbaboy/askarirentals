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

    <div class="container">
        <div class="centered-form">
            <h1>Signup</h1>
            <form method="post" action="">
                <input type="text" placeholder="Name" name="name" required>
                <input type="password" placeholder="Password" name="password" required>
                <input type="password" placeholder="Confirm Password" name="confirm_password" required>
                <input type="submit" value="Submit" name="submit">
                <p style="text-align: center;"><?php echo $message; ?></p>
            </form>  
        </div>
    </div>

<?php // Include the footer
include('footer.php');
?>

