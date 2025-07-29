<?php
session_start();
$conn = new mysqli("localhost", "root", "", "chat_app");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION["user_id"] = $id;
        $_SESSION["username"] = $username;
        header("Location: chat.php");
    } else {
        echo "Invalid login.";
    }
}
?>
<form method="POST">
    <input name="username" required>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
