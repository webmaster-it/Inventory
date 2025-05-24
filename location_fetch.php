
<?php
include 'dbconnection.php';

$result = $conn->query("SELECT l.*, t.name AS temperature FROM location_master l LEFT JOIN temperature_master t ON l.temperature_code = t.code ORDER BY l.id DESC");
$rows = [];

while($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
$conn->close();
?>
