<?php
$conn = new mysqli("localhost", "root", "", "chat_app");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: Username already exists.";
    }
}
?>
<form method="POST">
    <input name="username" required>
    <input type="password" name="password" required>
    <button type="submit">Register</button>
</form>
