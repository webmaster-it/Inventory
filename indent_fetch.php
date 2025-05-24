
<?php
include 'dbconnection.php';

$indents = [];
$indent_result = $conn->query("SELECT * FROM indent ORDER BY id DESC");

while ($indent = $indent_result->fetch_assoc()) {
    $indent_id = $indent['id'];
    $items = [];
    $item_result = $conn->query("SELECT * FROM indent_item WHERE indent_id = $indent_id");
    while ($item = $item_result->fetch_assoc()) {
        $items[] = $item;
    }
    $indent['items'] = $items;
    $indents[] = $indent;
}

echo json_encode($indents);
$conn->close();
?>
