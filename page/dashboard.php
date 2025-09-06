<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include("../includes/database.php");

// Shorten message to word limit
function shortenMessage($text, $limit = 20) {
    $words = explode(' ', $text);
    if (count($words) > $limit) {
        return implode(' ', array_slice($words, 0, $limit)) . '...';
    }
    return $text;
}

// Fetch latest 10 messages
$sql = "SELECT * FROM messages ORDER BY createdAt DESC LIMIT 10";
$result = $conn->query($sql);
$feedbacks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../public/css/dashboard.css">
<script src="../public/js/dashboard.js" defer></script>
</head>
<body>
<div class="dashboard-container">
    <h1>Admin Dashboard</h1>
    <!-- Logout button -->
    <form action="../includes/logout.php" method="post" style="display:inline;">
        <input type="submit" class="logout-btn" value="Logout">
    </form>

    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($feedbacks as $feedback): ?>
            <tr>
                <td><?= $feedback['id']; ?></td>
                <td><?= htmlspecialchars($feedback['email']); ?></td>
                <td>
                    <span class="message-preview" data-full="<?= htmlspecialchars($feedback['message']); ?>" data-limit="20">
                        <?= shortenMessage($feedback['message'], 20); ?>
                    </span>
                </td>
                <td class="action-buttons">
                    <button class="view-btn" data-id="<?= $feedback['id']; ?>">View</button>
                    <button class="reply-btn" data-id="<?= $feedback['id']; ?>">Reply</button>
                    <button class="delete-btn" data-id="<?= $feedback['id']; ?>">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- View Modal -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>View Message</h2>
        <p id="viewMessageText"></p>
    </div>
</div>

<!-- Reply Modal -->
<div id="replyModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Reply to Message</h2>
        <form id="replyForm">
            <textarea id="replyText" rows="5" placeholder="Type your reply..." required></textarea>
            <input type="hidden" id="replyId">
            <button type="submit">Send Reply</button>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this message?</p>
        <button id="confirmDelete">Yes, Delete</button>
        <button class="close-btn">Cancel</button>
    </div>
</div>
</body>
</html>
