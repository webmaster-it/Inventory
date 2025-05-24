
<?php
include 'dbconnection.php'; // your DB connection
 date_default_timezone_set('Asia/Kolkata');
$bookingstatusdatetime=date("Y-m-d H:i A");
$id = $_POST['id'] ?? null;
$code = $_POST['code'];
$name = $_POST['name'];
$desc = $_POST['description'];
$status = $_POST['status'];

if (!$name || !$code) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

if ($id) {
    $stmt = $conn->prepare("UPDATE category_master SET code=?, name=?, description=?, status=? WHERE id=?");
    $stmt->bind_param("ssssi", $code, $name, $desc, $status, $id);
} else {
    $stmt = $conn->prepare("INSERT INTO category_master (code, name, description, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $code, $name, $desc, $status);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
