
<?php
include 'dbconnection.php';

$id = $_POST['id'] ?? null;
$code = $_POST['code'];
$staff_code = $_POST['staff_code'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
$status = $_POST['status'];

if (!$username || !$password || !$code) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

//$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if ($id) {
    $stmt = $conn->prepare("UPDATE user_master SET code=?, staff_code=?, username=?, password=?, role=?, status=? WHERE id=?");
    $stmt->bind_param("ssssssi", $code, $staff_code, $username, $password, $role, $status, $id);
} else {
    $stmt = $conn->prepare("INSERT INTO user_master (code, staff_code, username, password, role, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $code, $staff_code, $username, $password, $role, $status);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
