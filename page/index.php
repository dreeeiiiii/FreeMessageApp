<?php
include("../includes/database.php");

$message = "";
$email = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message = trim($_POST['message']);
    $email= trim($_POST['email']);

    if (!empty($message) && !empty($email)) {
        $stmt = $conn->prepare("INSERT INTO messages (message, email ) VALUES (?, ?)");
        $stmt->bind_param("ss", $message , $email);

        if ($stmt->execute()) {
            $successMessage = "Your message has been submitted successfully!";
            $message = "";
        } else {
            $successMessage = "Error saving message. Please try again.";
        }
        $stmt->close();
    } else {
        $successMessage = "Please type a message before submitting.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leave a Message</title>
  <link rel="stylesheet" href="/Form-Project/public/css/index.css">
</head>
<body>
  <div class="background">
    <div class="form-container">
      <div class="form-card">
        <h2>Leave a Message</h2>

        <?php if (!empty($successMessage)): ?>
          <p class="form-feedback"><?php echo htmlspecialchars($successMessage); ?></p>
        <?php endif; ?>

        <form action="" method="post">
          <label for="email">Put your email to get your response</label>
          <input type="email" name="email" id="email">
          <label for="message">Your Message:</label>
          <textarea name="message" id="message" placeholder="Type your message..." rows="5"><?php echo htmlspecialchars($message); ?></textarea>
          <input type="submit" value="Send Message">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
