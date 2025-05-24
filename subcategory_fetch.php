
<?php
include 'dbconnection.php';

$result = $conn->query("SELECT s.*, c.name AS parent_name FROM subcategory_master s LEFT JOIN category_master c ON s.category_code = c.code ORDER BY s.id DESC");
$rows = [];

while($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
$conn->close();
?>
