
<?php
include 'dbconnection.php';

$id = $_POST['id'] ?? null;
$code = $_POST['code'];
$name = $_POST['name'];
$category_code = $_POST['category_code'];
$description = $_POST['description'];
$status = $_POST['status'];

if (!$name || !$code || !$category_code) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

if ($id) {
    $stmt = $conn->prepare("UPDATE subcategory_master SET code=?, name=?, category_code=?, description=?, status=? WHERE id=?");
    $stmt->bind_param("sssssi", $code, $name, $category_code, $description, $status, $id);
} else {
    $stmt = $conn->prepare("INSERT INTO subcategory_master (code, name, category_code, description, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $code, $name, $category_code, $description, $status);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
