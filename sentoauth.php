
<?php
include 'dbconnection.php';
$data = json_decode(file_get_contents('php://input'), true);

$vendor = $data['vendor'];
$items = $data['items'];
$po_number = 'PO' . time();
$created_by = 'admin'; // placeholder
$status = 'Pending Authorization';

$conn->begin_transaction();
try {
  $stmt = $conn->prepare("INSERT INTO purchase_order (po_number, vendor_code, status, created_by)
                          VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $po_number, $vendor, $status, $created_by);
  $stmt->execute();
  $po_id = $stmt->insert_id;
  $stmt->close();
  //print_r($po_id);
  $stmtItem = $conn->prepare("INSERT INTO purchase_order_item (po_id, item_code, manufacturer_code, qty, rate, tax, current_stock)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");

if (!$stmtItem) {
  die("Prepare failed: " . $conn->error);
}

foreach ($items as $item) {
  $stmtItem->bind_param("issdddd",
    $po_id,
    $item['code'],
    $item['manufacturer_code'],
    floatval($item['qty']),
    floatval($item['rate']),
    floatval($item['tax']),
    floatval($item['current_stock'])
  );

  if (!$stmtItem->execute()) {
    file_put_contents("item_error.txt", "Error: " . $stmtItem->error . "\\n", FILE_APPEND);
  }
}
$stmtItem->close();
  $conn->commit();
  echo json_encode(["success" => true, "po_number" => $po_number]);
} catch (Exception $e) {
  $conn->rollback();
  echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
$conn->close();
?>
