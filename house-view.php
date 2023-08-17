<?php
include 'session.php';
// Start or resume the session
session_start();

// Database connection setup
$servername = "localhost";
$username = "Jay";
$password = "1234";
$dbname = "patakejadatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch houses from the database
$sql = "SELECT * FROM houses";
$result = $conn->query($sql);
$houses = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $houses[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Houses Page</title>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
  <div class="dropdown">
    <a href="javascript:void(0);" class="dropbtn">My Houses</a>
    <div class="dropdown-content">
      <!-- List of user's houses -->
    </div>
  </div>
  <div class="dropdown">
    <a href="javascript:void(0);" class="dropbtn">All Houses</a>
    <div class="dropdown-content">
      <!-- List of all houses -->
    </div>
  </div>

  <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1) : ?>
    <div class="dropdown">
      <a href="javascript:void(0);" class="dropbtn">Add a New House</a>
      <div class="dropdown-content">
        <!-- Add new house form -->
      </div>
    </div>
  <?php endif; ?>

</div>
<!-- End of Navbar -->

<!-- ... (rest of your HTML code) ... -->
</body>
</html>
