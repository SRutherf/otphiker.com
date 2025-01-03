<?php
header("Content-Type: application/json");
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'], $data['column'], $data['value'], $data['table'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
    exit;
}

// Retrieve variables
$id = intval($data['id']);
$column = $data['column'];
$value = $data['value'];
$table = $data['table'];

// Validate selected column
$allowedColumns = ['status', 'drive1', 'drive2', 'meet'];
if (!in_array($column, $allowedColumns)) {
    echo json_encode(['success' => false, 'error' => 'Invalid column']);
    exit;
}

// Validate value for drive1, drive2, meet
if (in_array($column, ['drive1', 'drive2', 'meet']) && !in_array($value, [0, 1])) {
    echo json_encode(['success' => false, 'error' => 'Invalid value']);
    exit;
}

$conn->begin_transaction();

try {
	if ($table === 'attendance') {
		// Update the new selection
		$updateQuery = "UPDATE $table SET $column = '$value' WHERE id = $id";
		if (!$conn->query($updateQuery)) {
			throw new Exception($conn->error);
		}
	}
	if ($table === 'carpool') {
		// Handle "no-selection" for carpool table
		if ($id === 'noselect' && in_array($column, ['drive1', 'drive2', 'meet'])) {
			$resetQuery = "UPDATE $table SET $column = 0";
			if (!$conn->query($resetQuery)) {
				throw new Exception($conn->error);
			}
		} else {
			if (in_array($column, ['drive1', 'drive2', 'meet']) && $value === 1) {
				// Reset the previously selected row for the same column
				$resetQuery = "UPDATE $table SET $column = 0 WHERE $column = 1";
				$conn->query($resetQuery);
			}

			// Update the new selection
			$updateQuery = "UPDATE $table SET $column = '$value' WHERE id = $id";
			if (!$conn->query($updateQuery)) {
				throw new Exception($conn->error);
			}
		}
	}

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>