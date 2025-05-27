<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardId = $_POST['cardId'];
    $color = $_POST['color'];

    $conn = new mysqli("localhost", "root", "", "task_manager");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("REPLACE INTO card_colors (card_id, color) VALUES (?, ?)");
    $stmt->bind_param('ss', $cardId, $color);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}
?>