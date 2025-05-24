
<?php
include 'dbconnection.php';

$id = $_POST['id'] ?? null;
$code = $_POST['code'];
$name = $_POST['name'];
$temperature_code = $_POST['temperature_code'];
$description = $_POST['description'];
$status = $_POST['status'];

if (!$name || !$code || !$temperature_code) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

if ($id) {
    $stmt = $conn->prepare("UPDATE location_master SET code=?, name=?, temperature_code=?, description=?, status=? WHERE id=?");
    $stmt->bind_param("sssssi", $code, $name, $temperature_code, $description, $status, $id);
} else {
    $stmt = $conn->prepare("INSERT INTO location_master (code, name, temperature_code, description, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $code, $name, $temperature_code, $description, $status);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
