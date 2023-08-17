<?php
include 'session.php';

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: Log-in.html");
    exit();
}

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "patakejadatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $location = $_POST["location"];
    $houseType = $_POST["houseType"];
    $details = $_POST["details"];
    $uploadedBy = $_SESSION["email"]; // Assuming the user's email is stored in a session variable
    $dateUploaded = date("Y-m-d H:i:s");

    // Image handling
    $photo1 = file_get_contents($_FILES["image1Upload"]["tmp_name"]);
    $photo2 = file_get_contents($_FILES["image2Upload"]["tmp_name"]);
    $photo3 = file_get_contents($_FILES["image3Upload"]["tmp_name"]);

    // Prepare and execute SQL query
    $stmt = $conn->prepare("INSERT INTO houses (title, location, house_type, details, photo1, photo2, photo3, uploaded_by, date_uploaded) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssbbbs", $title, $location, $houseType, $details, $photo1, $photo2, $photo3, $uploadedBy, $dateUploaded);

    if ($stmt->execute()) {
        $_SESSION['house_added'] = [
            'status' => 'success',
            'message' => 'New house added.'
        ];
    } else {
        $_SESSION['house_added'] = [
            'status' => 'danger',
            'message' => 'Error: ' . $stmt->error
        ];
    }

    $stmt->close();
}

// Close database connection
$conn->close();
?>
