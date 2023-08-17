// After successful login
session_start();
$_SESSION['email'] = $email;
$_SESSION['role'] = $role;

// On other pages
session_start();
if (isset($_SESSION['email'])) {
    // User is logged in
} else {
    // User is not logged in
}
