<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat App</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #f0f4f7;
        }

        .chat-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .chat-header {
            background: #007bff;
            color: white;
            padding: 15px;
            font-size: 20px;
        }

        .chat-box {
            height: 400px;
            padding: 15px;
            overflow-y: auto;
            background: #f9f9f9;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .chat-box p {
            margin: 8px 0;
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 75%;
            line-height: 1.4;
        }

        .chat-box p b {
            display: block;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .sent {
            background: #d1e7ff;
            margin-left: auto;
            text-align: right;
        }

        .received {
            background: #e9ecef;
            margin-right: auto;
            text-align: left;
        }

        .message-form {
            display: flex;
            padding: 10px;
            background: #fff;
        }

        .message-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
            font-size: 16px;
        }

        .message-form button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-left: 10px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
        }

        .message-form button:hover {
            background: #0056b3;
        }
    </style>

    <script>
        function loadMessages() {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_messages.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("chatBox").innerHTML = xhr.responseText;
                    document.getElementById("chatBox").scrollTop = document.getElementById("chatBox").scrollHeight;
                }
            };
            xhr.send();
        }

        setInterval(loadMessages, 1000);
        window.onload = loadMessages;
    </script>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">
        Welcome, <?php echo htmlspecialchars($username); ?>
    </div>

    <div id="chatBox" class="chat-box">
        <!-- Messages will be loaded here -->
    </div>

    <form class="message-form" method="POST" action="send_message.php">
        <input type="text" name="message" placeholder="Type a message..." required autocomplete="off">
        <input type="hidden" name="receiver_id" value="2"> <!-- Replace with dynamic receiver if needed -->
        <button type="submit">Send</button>
    </form>
</div>

</body>
</html>
