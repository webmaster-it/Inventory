
<?php
include 'dbconnection.php';

$id = $_POST['id'] ?? null;
$code = $_POST['code'];
$name = $_POST['name'];
$min_celsius = $_POST['min_celsius'];
$max_celsius = $_POST['max_celsius'];
$status = $_POST['status'];

if (!$name || $min_celsius === '' || $max_celsius === '') {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

if ($id) {
    $stmt = $conn->prepare("UPDATE temperature_master SET code=?, name=?, min_celsius=?, max_celsius=?, status=? WHERE id=?");
    $stmt->bind_param("ssissi", $code, $name, $min_celsius, $max_celsius, $status, $id);
} else {
    $stmt = $conn->prepare("INSERT INTO temperature_master (code, name, min_celsius, max_celsius, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $code, $name, $min_celsius, $max_celsius, $status);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
