
<?php
include 'dbconnection.php';

$data = json_decode(file_get_contents('php://input'), true);

$indent_number = $data['indent_number'];
$indent_type = $data['indent_type'];
$indentor_code = $data['indentor_code'];
$requested_for_code = $data['requested_for_code'];
$items = $data['items'];

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("INSERT INTO indent (indent_number, indent_type, indentor_code, requested_for_code) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $indent_number, $indent_type, $indentor_code, $requested_for_code);
    $stmt->execute();
    $indent_id = $stmt->insert_id;
    $stmt->close();

    $item_stmt = $conn->prepare("INSERT INTO indent_item (indent_id, item_code, qty) VALUES (?, ?, ?)");
    foreach ($items as $item) {
        $item_stmt->bind_param("isi", $indent_id, $item['item_code'], $item['qty']);
        $item_stmt->execute();
    }
    $item_stmt->close();

    $conn->commit();
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
$conn->close();
?>
