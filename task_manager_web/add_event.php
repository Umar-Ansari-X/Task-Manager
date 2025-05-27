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

    $date = $data['date'];
    $timeRangeStart = $data['timeRangeStart'];
    $timeRangeEnd = $data['timeRangeEnd'];
    $name = $data['name'];
    $description = $data['description'];
    $color = $data['color'];

    if (empty($date) || empty($name) || empty($description) || empty($timeRangeStart) || empty($timeRangeEnd)) {
        echo json_encode(['status' => 'error', 'message' => 'Required fields are missing']);
        exit();
    }

    $conn = new mysqli("localhost", "root", "", "task_manager");
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO events (user_id, event_date, time_range_start, time_range_end, event_name, event_description, event_color) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $_SESSION['user_id'], $date, $timeRangeStart, $timeRangeEnd, $name, $description, $color);

    if ($stmt->execute()) {
        $eventId = $stmt->insert_id; /
        echo json_encode(['status' => 'success', 'eventId' => $eventId]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add event']);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
}
?>