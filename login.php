<?php
include 'session.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 0; // Default role value

    // Check user's role
    if (isset($_POST['userCheckbox'])) {
        $role = 0; // User role
    } elseif (isset($_POST['agentCheckbox'])) {
        $role = 1; // Agent role
    }

    $servername = "localhost";
    $username = "root";
    $dbpassword = "1234";
    $dbname = "patakejadatabase";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE email='$email' AND is_agent='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['password'] == $password) {
            // Credentials are correct, initiate session
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            header("Location: house-view.php"); // Redirect to success page
            exit();
        } else {
            echo "Wrong password, please try again.";
        }
    } else {
        echo "That user does not exist.";
    }

    $conn->close();
}
?>
