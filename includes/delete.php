<?php
include("database.php"); // your database connection

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // sanitize input

    // Delete query
    $sql = "DELETE FROM messages WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../page/dashboard.php"); // redirect back
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No ID specified.";
}
?>
