<?php
include 'header.php';
include 'dbconnection.php';
error_reporting();
$poid=$_GET['id'];
$resultss = $conn->query("SELECT vendor_code FROM purchase_order WHERE po_number='$poid'");
$rowss = $resultss->fetch_array();
//print_r($rowss);
$result = $conn->query("SELECT poi.id,poi.current_stock, po.po_number,item_master.name,item_master.code,poi.manufacturer_code,poi.qty,poi.rate,poi.tax,po.po_number,po.vendor_code,po.created_at,po.status FROM purchase_order po
INNER JOIN  purchase_order_item poi ON po.id  = poi.po_id INNER JOIN item_master ON item_master.code =poi.item_code WHERE poi.deleteitem='0' AND po.status='Pending Authorization' AND po.po_number='$poid'");
if (isset($_POST["submitauth"])) {
 $updateQuery = 'UPDATE `purchase_order` SET
  `status` = "Authorized"
  WHERE `po_number` = "'.$poid.'"';
  $rowsnew = $conn->query($updateQuery);
//print_r($updateQuery);
  header("Location: po_draft.php");
 $displaystr = "PO Authorization Successfully !!";
}
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
    .container { margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);  margin-top: 50px;}
    h2 { text-align: center; margin-bottom: 20px; }
    label { font-weight: bold; display: block; margin-top: 15px; }
    select, input[type="text"], input[type="number"] { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; vertical-align: middle; }
    th { background-color: #f0f0f0; }
    .btn { margin-top: 20px; background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px; }
    .btn:hover { background: #2c80b4; }
    .remove-btn { background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; }
    .remove-btn:hover { background: #c0392b; }
    .actions { margin-top: 30px; text-align: center; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Purchase Order Authorization</h2>
 <h4 class="card-title" style="color: green;"><?php if($displaystr != "") echo $displaystr;?></h4>
    <label for="vendor">Vendor Name: <?php echo $rowss['vendor_code']; ?></label>
  <form method="post" action="">
<input type="hidden" id="vendor" name="vendorname" value="<?php echo $rowss['vendor_code']; ?>">
    <table>
      <thead>
        <tr>
          <th>Item</th>
          <th>Internal Code</th>
          <th>Manufacturer Code</th>
          <th>Quantity</th>
          <th>Rate</th>
          <th>Current Stock</th>
          <th>Tax %</th>
        </tr>
      </thead>
      <tbody id="poTableBody">
        <?php
while($row = $result->fetch_assoc()) {
   // print_r($row);
      ?>
        <tr>
          <td><?php echo $row["name"]; ?></td>
          <td><?php echo $row["code"]; ?></td>
          <td><?php echo $row["manufacturer_code"]; ?></td>
          <td><?php echo $row["qty"]; ?></td>
          <td><?php echo $row["rate"]; ?></td>
          <td><?php echo $row["current_stock"]; ?></td>
          <td><?php echo $row["tax"]; ?></td>
        </tr>
        <?php

      }?>
        
      </tbody>
    </table>

    <div class="actions">
      <div class="actions">
      <button class="btn" type="submit" name="submitauth">Final Authorized</button>
    </div>
    </div>
  </div>
  </form>
</body>
</html>
