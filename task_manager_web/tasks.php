<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "task_manager");
$user_id = $_SESSION['user_id'];

$startDate = new DateTime();
$startDate->modify('-730 days');
$endDate = new DateTime();
$endDate->modify('+730 days');

$events = [];
$sql = "SELECT * FROM events WHERE user_id=$user_id AND event_date BETWEEN '" . $startDate->format('Y-m-d') . "' AND '" . $endDate->format('Y-m-d') . "'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $events[$row['event_date']][] = [
        'id' => $row['id'],
        'name' => $row['event_name'],
        'description' => $row['event_description'],
        'timeRangeStart' => $row['time_range_start'],
        'timeRangeEnd' => $row['time_range_end'],
        'color' => $row['event_color']
    ];
}

$days = [];
$currentDate = clone $startDate; 
while ($currentDate <= $endDate) {
    $dateStr = $currentDate->format('Y-m-d');
    $days[] = [
        'date' => $dateStr,
        'dayOfWeek' => $currentDate->format('l'),
        'formattedDate' => $currentDate->format('m/d/Y'),
        'events' => isset($events[$dateStr]) ? $events[$dateStr] : []
    ];
    $currentDate->modify('+1 day');
}

header('Content-Type: application/json');
echo json_encode($days);
?>