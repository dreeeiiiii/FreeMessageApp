<?php
session_start();

// Admin credentials (for demo only, later use hashed passwords)
$adminEmail = "admin@gmail.com";
$adminPassword = "12345678";

$errormessage = "";
$email = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize user input
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    // Validate credentials
    if ($email === $adminEmail && $password === $adminPassword) {
        // Login successful, set session
        $_SESSION['user'] = $email;
        header("Location: ../page/dashboard.php");
        exit;
    } elseif ($email !== $adminEmail && $password !== $adminPassword) {
        $errormessage = "Wrong email and password";
    } elseif ($email !== $adminEmail) {
        $errormessage = "Wrong email";
    } else {
        $errormessage = "Wrong password";
    }
}
?>
