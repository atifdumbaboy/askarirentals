<?php
// Check if $username is set in the session
if (isset($_SESSION['username'])) {
    // User is logged in
    $username = $_SESSION['username'];
    $dashboardNavItem = '<li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>';
    $loginNavItem = '<li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>';
    $signupNavItem = ''; // Don't display the signup link when logged in
} else {
    // User is not logged in
    $dashboardNavItem = ''; // Don't display the dashboard link
    $loginNavItem = '<li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>';
    $signupNavItem = '<li class="nav-item">
                        <a class="nav-link" href="signup.php">Signup</a>
                    </li>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Askari Rentals</title>
    <link rel="icon" href="media/logo.png">

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add custom CSS for hover effect -->
    <style>
        .navbar-light .navbar-nav .nav-link:hover {
            color: #fff; /* Change the text color on hover to white */
            background-color: #007bff; /* Change the background color on hover to green */
            border-radius: 7%;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Include the Montserrat font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="extrastyle.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background:linear-gradient(to bottom, lightseagreen, transparent)">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="media/logo.png" alt="Logo" height="100">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <?php echo $dashboardNavItem; ?> <!-- Display Dashboard nav-item if logged in -->
                <?php echo $signupNavItem; ?> <!-- Display Signup nav-item if not logged in -->
                <?php echo $loginNavItem; ?> <!-- Display Login or Logout nav-item -->
                <li class="nav-item">
                    <a class="nav-link" href="search.php">
                        <i class="fa fa-search"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
