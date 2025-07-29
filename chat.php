<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
$conn = new mysqli("localhost", "root", "", "chat_app");

// Get all users except current user
$result = $conn->query("SELECT id, username FROM users WHERE id != {$_SESSION['user_id']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat App</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 700px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h3, h4 {
            text-align: center;
            color: #333;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-size: 14px;
        }

        form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        select, input[type="text"] {
            padding: 10px;
            font-size: 14px;
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 15px;
            font-size: 14px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        #chat-box {
            max-height: 400px;
            overflow-y: auto;
            background: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
        }

        #chat-box p {
            margin: 8px 0;
            padding: 8px 12px;
            background: #fff;
            border-left: 4px solid #007BFF;
            border-radius: 4px;
        }

        #chat-box p b {
            color: #007BFF;
        }
    </style>
</head>
<body>
<div class="container">
    <h3>Welcome, <?= $_SESSION["username"] ?> | <a href="logout.php">Logout</a></h3>

    <form method="POST" action="send_message.php">
        <select name="receiver_id">
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['username']) ?></option>
            <?php endwhile; ?>
        </select>
        <input name="message" type="text" placeholder="Type message..." required>
        <button type="submit">Send</button>
    </form>

    <h4>Messages</h4>
    <div id="chat-box">
        <?php
        $messages = $conn->query("
            SELECT u.username AS sender, m.message, m.timestamp
            FROM messages m
            JOIN users u ON m.sender_id = u.id
            WHERE m.sender_id = {$_SESSION['user_id']} OR m.receiver_id = {$_SESSION['user_id']}
            ORDER BY m.timestamp DESC
        ");
        while ($msg = $messages->fetch_assoc()):
        ?>
            <p><b><?= htmlspecialchars($msg['sender']) ?>:</b> <?= htmlspecialchars($msg['message']) ?> <small style="float:right; font-size:12px; color:#666;"><?= $msg['timestamp'] ?></small></p>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
