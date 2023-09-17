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

<div class="container-fluid min-vh-100"> <!-- Ensure the main container fills at least the viewport height -->
    <div class="row justify-content-center align-items-center min-vh-100"> <!-- Center content vertically -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Login Form</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        <p class="text-center mt-3"><?php echo $message; ?></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php // Include the footer
include('footer.php');
?>
