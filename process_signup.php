<?php
include 'session.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $phone = $_POST['phone'];
    $userEmail = $_POST['email'];
    $password = $_POST['password'];
    $role = ''; // Initialize role variable

    // Check user's role
    if (isset($_POST['userCheckbox'])) {
        $role = 0; // Assuming 0 represents 'user' in the database
    } elseif (isset($_POST['agentCheckbox'])) {
        $role = 1; // Assuming 1 represents 'agent' in the database
    }

    // Validate inputs, connect to the database, and save user info
    $servername = "localhost";
    $username = "root";
    $dbpassword = "1234";
    $dbname = "patakejadatabase";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check for existing user based on name, email, and phone number
    $nameCheckQuery = "SELECT * FROM users WHERE fName='$firstName' AND lName='$lastName'";
    $emailCheckQuery = "SELECT * FROM users WHERE email='$userEmail'";
    $phoneCheckQuery = "SELECT * FROM users WHERE phone='$phone'"; // Corrected column name

    $nameResult = $conn->query($nameCheckQuery);
    $emailResult = $conn->query($emailCheckQuery);
    $phoneResult = $conn->query($phoneCheckQuery);

    if ($nameResult->num_rows > 0) {
        echo "Error: This name combination already exists.";
    } elseif ($emailResult->num_rows > 0 || $phoneResult->num_rows > 0) {
        echo "Error: This user account already exists.";
    } else {
        // Upload and handle image
        $photo = null; // Initialize photo variable

        if (!empty($_FILES['imageInput']['name'])) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES['imageInput']['name']);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedExtensions = array("jpg", "jpeg", "png", "gif");

            if (in_array($imageFileType, $allowedExtensions)) {
                if (move_uploaded_file($_FILES['imageInput']['tmp_name'], $targetFile)) {
                    $photo = $targetFile;
                }
            }
        }

        $sql = "INSERT INTO users (fName, lName, phone, email, password, photo, is_agent)
                VALUES ('$firstName', '$lastName', '$phone', '$userEmail', '$password', '$photo', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "New User Created.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
