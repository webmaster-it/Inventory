
<?php
include 'dbconnection.php';

$id = $_POST['id'] ?? null;
$code = $_POST['code'];
$name = $_POST['name'];
$description = $_POST['description'];
$status = $_POST['status'];

if (!$name || !$code) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

if ($id) {
    $stmt = $conn->prepare("UPDATE department_master SET code=?, name=?, description=?, status=? WHERE id=?");
    $stmt->bind_param("ssssi", $code, $name, $description, $status, $id);
} else {
    $stmt = $conn->prepare("INSERT INTO department_master (code, name, description, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $code, $name, $description, $status);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
