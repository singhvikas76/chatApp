<?php
session_start();
require 'db.php';

$current_user = $_SESSION['user_id'];

$sql = "SELECT messages.*, 
       sender.username AS sender_name,
       receiver.username AS receiver_name
       FROM messages 
       JOIN users AS sender ON messages.sender_id = sender.id
       JOIN users AS receiver ON messages.receiver_id = receiver.id
       WHERE sender_id = $current_user OR receiver_id = $current_user
       ORDER BY messages.created_at ASC";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    if ($row['sender_id'] == $current_user) {
        echo "<p class='sent'><b>You</b>" . htmlspecialchars($row['message']) . "</p>";
    } else {
        echo "<p class='received'><b>" . htmlspecialchars($row['sender_name']) . "</b>" . htmlspecialchars($row['message']) . "</p>";
    }
}
?>
