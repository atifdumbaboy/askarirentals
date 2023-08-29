<?php
include_once('connection.php');

$message = ''; // Initialize an empty message

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Create a prepared statement
    $stmt = mysqli_prepare($mysqli, "SELECT id, Password FROM users WHERE Name=?");

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "s", $name);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result
    mysqli_stmt_bind_result($stmt, $id, $hashed_password);

    if (mysqli_stmt_fetch($stmt)) {
        // User exists, verify the password
        if (password_verify($password, $hashed_password)) {
            session_start(); // Start a new session

            // Store user information in the session for later use
            $_SESSION['username'] = $name;

            // Redirect to a specific page after successful login
            header("Location: dashboard.php"); // Change 'dashboard.php' to your desired page

            exit(); // Make sure to exit after redirection
        } else {
            $message = "Incorrect credentials";
        }
    } else {
        // User does not exist
        $message = "User does not exist.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>


<?php // Include the header
include('header.php');
?>
    
    <div class="container">
        <div class="centered-form">
            <h1>Login Form</h1>
            <form method="post">
                <input type="text" placeholder="Enter your name" name="name" required>
                <input type="password" placeholder="Enter your password" name="password" required>
                <input type="submit" value="Submit" name="submit">
                <p style="text-align: center;"><?php echo $message; ?></p>
            </form>
        </div>
    </div>
    
<?php // Include the footer
include('footer.php');
?>

