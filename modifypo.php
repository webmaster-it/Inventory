<?php
include 'header.php';
include 'dbconnection.php';
error_reporting();
$poid=$_GET['id'];
$resultss = $conn->query("SELECT vendor_code FROM purchase_order WHERE po_number='$poid'");
$rowss = $resultss->fetch_array();
$result = $conn->query("SELECT poi.id AS poiid,po.id,poi.current_stock, po.po_number,item_master.name,item_master.code,poi.manufacturer_code,poi.qty,poi.rate,poi.tax,po.po_number,po.vendor_code,po.created_at,po.status FROM purchase_order po
INNER JOIN  purchase_order_item poi ON po.id  = poi.po_id INNER JOIN item_master ON item_master.code =poi.item_code WHERE poi.deleteitem='0' AND po.po_number='$poid'");
$vendorname=$rowss['vendor_code'];
$resultss1 = $conn->query("SELECT * FROM item_master WHERE default_vendor = '$vendorname' AND status = 'Active'");
//print_r($sqlBooking);
?>

  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
    .container { max-width: 1000px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);  margin-top: 50px;}
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
  <script>
   
    function removeRow(btn) {
      const row = btn.closest('tr');
      row.remove();
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Modify Purchase Order - Vendor Name: <?php echo $rowss['vendor_code']; ?></h2>

    <label for="vendor">Select Vendor</label>
    <select id="vendor" name="vendorname">
      <option>Select Vendor</option>
     
<option value="<?php echo $rowss['vendor_code']; ?>">
      <?php echo $rowss['vendor_code']; ?></option>
   
      
    </select>
 <input type="hidden" name="vendorcode" id="vendorcode" value="<?php echo $rowss['vendor_code']; ?>">
 <input type="hidden" name="povenid" id="povenid" value="<?php echo $poid; ?>">
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
          <th>Remove</th>
        </tr>
      </thead>
      <tbody id="poTableBody">
           <?php
while($row = $result->fetch_assoc()) {
   // print_r($row);
      ?>
         <tr>
          <td>
            <input type="hidden" name="poiid" value="<?php echo $row["poiid"]; ?>" id="poiid">
            <input type="hidden" name="poidd" value="<?php echo $row["id"]; ?>" id="poidd">

  <input type="text" value="<?php echo $row["name"]; ?>" name="" readonly>
          </td>
          <td><input type="text" value="<?php echo $row["code"]; ?>" name="" readonly></td>
          <td><input type="text" value="<?php echo $row["manufacturer_code"]; ?>" name="manufacturercode" readonly></td>
          <td><input type="text" value="<?php echo $row["qty"]; ?>" name="quantity1" id="quantity1" readonly></td>
          <td><input type="text" value="<?php echo $row["rate"]; ?>" name="rate" readonly></td>
          <td><input type="text" value="<?php echo $row["current_stock"]; ?>" name="stock" readonly></td>
          <td><input type="text" value="<?php echo $row["tax"]; ?>" name="tax" readonly></td>
          <td><a href="deletepo.php?id=<?=$row["poiid"]?>&po=<?=$poid?>" class="remove-btn">X</a></td>
        </tr>
          <?php

      }?>
      </tbody>
    </table>
    <div class="actions">
      <button class="btn" type="button" id="addRowBtn">Add Row</button>
      <button class="btn" type="submit" name="submitpo" onclick="submitPO()">Save PO Draft</button>
      <button class="btn" type="submit" name="submitauth" onclick="submitPOA()">Send for Authorization</button>
    </div>
  </div>
<script>
function removeRow(btn) {
  const row = btn.closest('tr');
  row.remove();
}
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById('vendor').addEventListener('change', function () {
    const vendor = this.value;
    fetch('get_items_by_vendor.php?vendor=' + encodeURIComponent(vendor))
      .then(res => res.json())
      .then(data => {
        document.getElementById('addRowBtn').onclick = () => addRow(data);
        addRow(data); // Add one row by default
      });
  });
});

function addRow(itemList) {
  const table = document.getElementById('poTableBody');
  const row = table.insertRow();

  const select = document.createElement('select');
  select.innerHTML = "<option value=''>Select Item</option>";
  itemList.forEach(item => {
    const opt = document.createElement('option');
    opt.value = JSON.stringify(item);
    opt.text = item.name;
    select.appendChild(opt);
  });
  select.setAttribute('onchange', 'fillItemDetails(this)');

  row.innerHTML = `
    <td></td>
    <td><input type="text" readonly name="itemcode"></td>
    <td><input type="text" readonly name="manufacturercode"></td>
    <td><input type="number" name="quantity"></td>
    <td><input type="number" readonly name="rate"></td>
    <td><input type="text" readonly name="stock"></td>
    <td><input type="number" readonly name="tax"></td>
    <td><button type="button" class='remove-btn' onclick='removeRow(this)'>X</button></td>
  `;
  row.cells[0].appendChild(select);
}

function fillItemDetails(select) {
  const item = JSON.parse(select.value);
  const row = select.closest('tr');
  row.cells[1].querySelector('input').value = item.code;
  row.cells[2].querySelector('input').value = item.manufacturer_code;
  row.cells[4].querySelector('input').value = item.default_rate;
  row.cells[5].querySelector('input').value = item.current_stock;
  row.cells[6].querySelector('input').value = item.tax;
}
</script>


<script>
function submitPO() {
  const vendor = document.getElementById("vendor").value;
  const vendorcode = document.getElementById("vendorcode").value;
  const poiid = document.getElementById("poiid").value;
  const poidd = document.getElementById("poidd").value;
  const quantity1 = document.getElementById("quantity1").value;
  const tableRows = document.querySelectorAll("#poTableBody tr");

  if (!vendor) {
    alert("Please select a vendor.");
    return;
  }

  const items = [];

  tableRows.forEach(row => {
    const itemSelect = row.cells[0].querySelector('select');
    const item = itemSelect ? JSON.parse(itemSelect.value) : null;
    const qty = parseFloat(row.cells[3].querySelector('input')?.value || 0);

    if (item && qty > 0) {
      items.push({
        code: item.code,
        manufacturer_code: item.manufacturer_code,
        qty: qty,
        rate: parseFloat(row.cells[4].querySelector('input')?.value || 0),
        current_stock: parseFloat(row.cells[5].querySelector('input')?.value || 0),
        tax: parseFloat(row.cells[6].querySelector('input')?.value || 0)
      });
    }
  });

  /*if (items.length === 0) {
    alert("Please add at least one item with quantity.");
    return;
  }*/

  const payload = { vendor, vendorcode, poiid, poidd, quantity1, items };

  fetch('posave.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert("PO saved successfully! PO Number: " + data.po_number);
      location.reload();
    } else {
      alert("Error saving PO: " + data.message);
    }
  });
}
</script>
<script>
function submitPOA() {
  const vendor = document.getElementById("vendor").value;
  const vendorcode = document.getElementById("vendorcode").value;
  const poiid = document.getElementById("poiid").value;
  const poidd = document.getElementById("poidd").value;
  const quantity1 = document.getElementById("quantity1").value;
  const tableRows = document.querySelectorAll("#poTableBody tr");

  if (!vendor) {
    alert("Please select a vendor.");
    return;
  }

  const items = [];

  tableRows.forEach(row => {
    const itemSelect = row.cells[0].querySelector('select');
    const item = itemSelect ? JSON.parse(itemSelect.value) : null;
    const qty = parseFloat(row.cells[3].querySelector('input')?.value || 0);

    if (item && qty > 0) {
      items.push({
        code: item.code,
        manufacturer_code: item.manufacturer_code,
        qty: qty,
        rate: parseFloat(row.cells[4].querySelector('input')?.value || 0),
        current_stock: parseFloat(row.cells[5].querySelector('input')?.value || 0),
        tax: parseFloat(row.cells[6].querySelector('input')?.value || 0)
      });
    }
  });

 /* if (items.length === 0) {
    alert("Please add at least one item with quantity.");
    return;
  }*/

  const payload = { vendor, vendorcode, poiid, poidd, quantity1, items };

  fetch('posendsuth.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert("PO saved successfully! PO Number: " + data.po_number);
      location.reload();
    } else {
      alert("Error saving PO: " + data.message);
    }
  });
}
</script>
</body>
</html>
