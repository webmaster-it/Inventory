
<?php
include 'dbconnection.php';

$data = json_decode(file_get_contents('php://input'), true);

$code = $data['code'];
$name = $data['name'];
$category = $data['category'];
$subcategory = $data['subcategory'];
$department = $data['department'];
$purchase_unit = $data['purchase_unit'];
$issue_unit = $data['issue_unit'];
$conversion_factor = $data['conversion_factor'];
$pack_size = $data['pack_size'];
$manufacturer = $data['manufacturer'];
$manufacturer_code = $data['manufacturer_code'];
$default_vendor = $data['default_vendor'];
$default_rate = $data['default_rate'];
$secondary_vendors = $data['secondary_vendors'];
$reorder_level = $data['reorder_level'];
$opening_stock = $data['opening_stock'];
$min_order_qty = $data['min_order_qty'];
$storage_location = $data['storageLocation'];
$storage_temp = $data['storageTemp'];
$expiry_applicable = $data['expiryApplicable'];
$batch_tracking = $data['batchTracking'];
$min_expiry_days = $data['minExpiryField'];
$purchase_lead_time = $data['purchase_lead_time'];
$tax = $data['tax'];
$amcc = $data['amcc'];
$status = $data['status'];

$stmt = $conn->prepare("INSERT INTO item_master (
    code, name, category, subcategory, department, purchase_unit, issue_unit, conversion_factor, pack_size,
    manufacturer, manufacturer_code, default_vendor, default_rate, secondary_vendors, reorder_level,
    opening_stock, min_order_qty, storage_location, storage_temp, expiry_applicable, batch_tracking,
    min_expiry_days, purchase_lead_time, tax,amcc, status
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$secondary_vendors_json = json_encode($secondary_vendors);
$stmt->bind_param("sssssssssssssidddssssiiids",
    $code, $name, $category, $subcategory, $department, $purchase_unit, $issue_unit,
    $conversion_factor, $pack_size, $manufacturer, $manufacturer_code, $default_vendor,
    $default_rate, $secondary_vendors_json, $reorder_level, $opening_stock, $min_order_qty,
    $storage_location, $storage_temp, $expiry_applicable, $batch_tracking, $min_expiry_days,
    $purchase_lead_time, $tax, $amcc, $status
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
