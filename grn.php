<?php
include 'header.php';
include 'dbconnection.php';
$id=$_GET['id'];
$result = $conn->query("SELECT poi.id AS poiid,po.id,poi.current_stock, po.po_number,item_master.name,item_master.code,poi.manufacturer_code,poi.qty,poi.rate,poi.tax,po.po_number,po.vendor_code,po.created_at,po.status,sc.name AS scname,cm.name AS cmname,item_master.batch_tracking,item_master.storage_location FROM purchase_order po
INNER JOIN  purchase_order_item poi ON po.id  = poi.po_id INNER JOIN item_master ON item_master.code =poi.item_code INNER JOIN subcategory_master sc ON item_master.subcategory_code = sc.code INNER JOIN category_master cm ON item_master.category_code = cm.code WHERE poi.deleteitem='0' AND po.po_number='$id'");
$result1 = $conn->query("SELECT * FROM purchase_order WHERE po_number='$id'");
$row = $result1->fetch_assoc();
if (isset($_POST['submit'])) {
 $vendorname=$_POST['vendorname'];
 $poid=$_POST['poid'];
 $invoicenumber=$_POST['invoicenumber'];
 $invoicedate=$_POST['invoicedate'];
 $grndatetimes=$_POST['grndatetimes'];
 $batchno=$_POST['batchno'];
 $expirydate=$_POST['expirydate'];
 $minexpiryday=$_POST['minexpiryday'];
  $chkAdd = $_POST['chkAdd'];
  $itemname = $_POST['itemname'];
  $freez = $_POST['freez'];
  $freezer = $_POST['freezer'];
  $rooms = $_POST['rooms'];
  $receivedquantity = $_POST['receivedquantity'];
  $po_number = 'GRN' . time();
  $status="Accepted";
$grnins='INSERT INTO `grnn`(`grn_number`, `po_id`, `vendorname`, `received_by`, `invoice_number`, `invoice_date`,`freeze`,`freezer`,`rooms`, `grndatetimesin`, `status`)VALUES ("'.$po_number.'","'.$poid.'","'.$vendorname.'","'.$strEmployeeName.'","'.$invoicenumber.'","'.$invoicedate.'","'.$freez.'","'.$freezer.'","'.$rooms.'","'.$grndatetimes.'","'.$status.'")';
  //print_r($grnins);
$rowsnew = $conn->query($grnins);
$last_id = $conn->insert_id;
 $displaystr = "GRN Update Successfully !!";
    for($i=0; $i <sizeof($chkAdd); $i++)
    {
        $sqladdCat = 'INSERT INTO `grn_item`(`grn_id`, `purchaseorderitem`,`item_code`, `batch_no`, `expiry_date`, `expiryday`, `received_qty`)
          VALUES ("'.$last_id.'","'.$chkAdd[$i].'","'.$itemname[$i].'","'.$batchno[$i].'","'.$expirydate[$i].'","'.$minexpiryday[$i].'","'.$receivedquantity[$i].'")';
         //   print_r($sqladdCat);
            $rowsnew1 = $conn->query($sqladdCat);
            $sqladdCat11 = 'INSERT INTO `stock_ledger`(`item_code`, `batch_no`, `qty_in`)
          VALUES ("'.$itemname[$i].'","'.$batchno[$i].'","'.$receivedquantity[$i].'")';
         //   print_r($sqladdCat);
            $rowsnew111 = $conn->query($sqladdCat11);
    }
}
//print_r($row);
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
    .container { max-width: 1100px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 50px; }
    h2 { text-align: center; margin-bottom: 20px; }
    label { font-weight: bold; display: block; margin-top: 15px; }
    input, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; vertical-align: middle; }
    th { background-color: #f0f0f0; }
    .btn { background: #3498db; color: white; padding: 10px 20px; margin: 10px 5px 0 0; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background: #2980b9; }
    .section { margin-top: 25px; }
    .remove-btn { background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; }
    .remove-btn:hover { background: #c0392b; }
  </style>
  <script>
    function viewPhoto(itemName) {
      alert('Show photo for: ' + itemName + '\n(Pull from Item Master)');
    }

    function removeRow(btn) {
      btn.closest('tr').remove();
    }
  </script>
</head>
<body>
  <div class="container">

    <h2>Goods Receipt Note (GRN)</h2>
    <h4 class="card-title" style="color: green;"><?php if($displaystr != "") echo $displaystr;?></h4>
<form method="post" action="">
    <div class="section">
      <label>Vendor</label>
      <input type="text" value="<?php echo $row["vendor_code"]; ?>" name="vendorname" readonly>

      <label>Linked Purchase Order</label>
      <input type="text" value="<?php echo $row["po_number"]; ?>" name="poid" readonly>

      <label>Vendor Invoice No.</label>
      <input type="text" placeholder="Enter Invoice Number" name="invoicenumber">

      <label>Vendor Invoice Date</label>
      <input type="date" value="" name="invoicedate">

      <label>GRN Date & Time</label>
      <input type="text" value="<?php echo $row["grndatetimess"]; ?>" name="grndatetimes" readonly>
    </div>

    <div class="section">
      <h4>Temperature at Receipt (Per Category)</h4>
      <label>Fridge (2°C to 8°C)</label>
      <input type="text" placeholder="Enter received temperature for Fridge items" name="freez">
      <label>Freezer (-20°C)</label>
      <input type="text" placeholder="Enter received temperature for Freezer items" name="freezer">
      <label>Room (15°C to 25°C)</label>
      <input type="text" placeholder="Enter received temperature for Room items" name="rooms">
    </div>

    <table>
      <thead>
        <tr>
          <th>Item</th>
          <th>Category</th>
          <th>Subcategory</th>
          <th>PO Qty</th>
          <th>Received So Far</th>
          <th>Pending Qty</th>
          <th>Receive Now</th>
          <th>Batch No.</th>
          <th>Expiry Date</th>
          <th>Min Expiry Days</th>
          <th>Storage</th>
          <th>Photo</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>
              <?php
while($rowss = $result->fetch_assoc()) {
  $qty=$rowss["qty"];
  $received_qty=$rowss["received_qty"];
  $pendingqty=$qty-$received_qty;

   // print_r($row);
      ?>
        <tr>
<input type="hidden" name="chkAdd[]" value="<?=$rowss['poiid']?>">
<input type="hidden" name="itemname[]" value="<?php echo $rowss["code"]; ?>">
          <td><?php echo $rowss["name"]; ?></td>
          <td><?php echo $rowss["cmname"]; ?></td>
          <td><?php echo $rowss["scname"]; ?></td>
          <td><?php echo $rowss["qty"]; ?></td>
          <td><?php echo $rowss["received_qty"]; ?></td>
          <td><?php echo $pendingqty; ?></td>
          <td><input type="number" value="0" name="receivedquantity[]"></td>
          <?php 
if ($rowss["batch_tracking"]=='1') {
           ?>
          
          <td><input type="text" placeholder="If batch-tracked" name="batchno[]"></td>
          <td><input type="date" name="expirydate[]"></td>
          <td><input type="number" placeholder="If applicable" name="minexpiryday[]"></td>
        <?php }else{ ?>
          <td></td>
          <td></td>
          <td></td>
        <?php } ?>
          <td><?php echo $rowss["storage_location"]; ?></td>
          <td><button class="btn" type="button" onclick="viewPhoto('Syringe 5ml')">View Photo</button></td>
          <td><button type="button" class="remove-btn" onclick="removeRow(this)">X</button></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>

    <div class="section">
      <button class="btn" type="submit" name="submit">Save GRN</button>
      <button class="btn">Cancel</button>
    </div>
    </form>
  </div>
</body>
</html>
