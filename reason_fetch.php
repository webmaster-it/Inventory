
<?php
include 'dbconnection.php';

$result = $conn->query("SELECT * FROM reason_master ORDER BY id DESC");
$rows = [];

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
$conn->close();
?>
