
<?php
include 'dbconnection.php';

$id = $_POST['id'] ?? null;
$code = $_POST['code'];
$name = $_POST['name'];
$role = $_POST['role'];
$contact = $_POST['contact'];
$departments = $_POST['departments']; // comma-separated
$linked_user_code = $_POST['linked_user_code'];
$status = $_POST['status'];

if (!$name || !$code) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

if ($id) {
    $stmt = $conn->prepare("UPDATE staff_master SET code=?, name=?, role=?, contact=?, departments=?, linked_user_code=?, status=? WHERE id=?");
    $stmt->bind_param("sssssssi", $code, $name, $role, $contact, $departments, $linked_user_code, $status, $id);
} else {
    $stmt = $conn->prepare("INSERT INTO staff_master (code, name, role, contact, departments, linked_user_code, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $code, $name, $role, $contact, $departments, $linked_user_code, $status);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
