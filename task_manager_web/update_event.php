<?php
header('Content-Type: application/json');

try {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit();
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit();
    }

    $eventId = $data['id'];
    $name = $data['name'];
    $description = $data['description'];
    $color = $data['color'];

    if (empty($eventId) || empty($name) || empty($description) || empty($color)) {
        echo json_encode(['status' => 'error', 'message' => 'Required fields are missing']);
        exit();
    }

    $conn = new mysqli("localhost", "root", "", "task_manager");
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit();
    }

    $stmt = $conn->prepare("UPDATE events SET event_name = ?, event_description = ?, event_color = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sssii", $name, $description, $color, $eventId, $_SESSION['user_id']);

    if ($stmt->execute()) {

        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No changes made or event not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update event']);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
}
?>