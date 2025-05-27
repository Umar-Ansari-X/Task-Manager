<?php
$conn = new mysqli("localhost", "root", "", "task_manager");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT card_id, color FROM card_colors";
$result = $conn->query($sql);

$colors = [];
while ($row = $result->fetch_assoc()) {
    $colors[$row['card_id']] = $row['color'];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($colors);
?>