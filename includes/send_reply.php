<?php
include("database.php"); // Your DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $message = trim($_POST['message']);

    // Get the user's email from database
    $stmt = $conn->prepare("SELECT email FROM messages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    if (!$email) {
        echo "No email found for this message.";
        exit;
    }

    // Send email
    $subject = "Reply to your message";
    $headers = "From: your_email@example.com\r\n";
    $headers .= "Reply-To: your_email@example.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($email, $subject, $message, $headers)) {
        echo "Reply sent successfully to $email.";
    } else {
        echo "Failed to send reply. Check your mail server settings.";
    }
} else {
    echo "Invalid request.";
}
?>
