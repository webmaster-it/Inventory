
<?php
include 'dbconnection.php';

$items = [];
$result = $conn->query("SELECT * FROM item_master ORDER BY id DESC");

while ($row = $result->fetch_assoc()) {
    $row['secondary_vendors'] = json_decode($row['secondary_vendors'], true);
    $items[] = $row;
}

echo json_encode($items);
$conn->close();
?>
