
<?php
include 'dbconnection.php';

$result = $conn->query("SELECT * FROM user_master ORDER BY id DESC");
$rows = [];

while ($row = $result->fetch_assoc()) {
    unset($row['password']); // never expose password hash
    $rows[] = $row;
}

echo json_encode($rows);
$conn->close();
?>
