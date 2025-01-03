<?php
header("Content-Type: application/json");
include 'db.php';

$response = ["attendance" => [], "carpool" => [], "idMatcher" => [], "lastUpdate" => time()];

// Fetch attendance data
$result = $conn->query("SELECT * FROM attendance");
while ($row = $result->fetch_assoc()) {
    $response["attendance"][] = $row;
}

// Fetch carpool data
$result = $conn->query("SELECT * FROM carpool");
while ($row = $result->fetch_assoc()) {
    $response["carpool"][] = $row;
}

echo json_encode($response);
?>
