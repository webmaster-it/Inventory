
<?php
include 'dbconnection.php';

$id = $_POST['id'] ?? null;
$code = $_POST['code'];
$name = $_POST['name'];
$senior_manager = $_POST['senior_manager'];
$senior_email = $_POST['senior_email'];
$senior_phone = $_POST['senior_phone'];
$account_manager = $_POST['account_manager'];
$account_email = $_POST['account_email'];
$account_phone = $_POST['account_phone'];
$pan = $_POST['pan'];
$gst = $_POST['gst'];
$address = $_POST['address'];
$status = $_POST['status'];

if (!$name || !$code) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

if ($id) {
    $stmt = $conn->prepare("UPDATE vendor_master SET code=?, name=?, senior_manager=?, senior_email=?, senior_phone=?, account_manager=?, account_email=?, account_phone=?, pan=?, gst=?, address=?, status=? WHERE id=?");
    $stmt->bind_param("ssssssssssssi", $code, $name, $senior_manager, $senior_email, $senior_phone, $account_manager, $account_email, $account_phone, $pan, $gst, $address, $status, $id);
} else {
    $stmt = $conn->prepare("INSERT INTO vendor_master (code, name, senior_manager, senior_email, senior_phone, account_manager, account_email, account_phone, pan, gst, address, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $code, $name, $senior_manager, $senior_email, $senior_phone, $account_manager, $account_email, $account_phone, $pan, $gst, $address, $status);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
