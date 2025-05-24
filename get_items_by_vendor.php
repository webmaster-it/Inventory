
<?php
include 'dbconnection.php';

$vendor = $_GET['vendor'] ?? '';
$items = [];

if ($vendor) {
    //$test="SELECT * FROM item_master WHERE default_vendor = '$vendor' AND status = 'Active'";
    $stmt = $conn->prepare("SELECT * FROM item_master WHERE default_vendor = ? AND status = 'Active'");
   // print_r($test);
    $stmt->bind_param("s", $vendor);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    $stmt->close();
}

echo json_encode($items);
$conn->close();
?>
