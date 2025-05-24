<?php
include 'header.php';
include 'dbconnection.php';
error_reporting();
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
    <h2>Manual Purchase Order - Vendor Wise</h2>

    <label for="vendor">Select Vendor</label>
    <select id="vendor" name="vendorname">
      <option>Select Vendor</option>
      <?php
$cat_resultven = $conn->query("SELECT * FROM vendor_master WHERE status='Active'");
while ($rowdven = $cat_resultven->fetch_assoc()) {
    
    ?>
<option value="<?= $rowdven['name'] ?>">
      <?= $rowdven['name'] ?></option>
    <?php


}
        ?>
      
    </select>

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
       <!--  <tr>
          <td><input type="text" placeholder="Search Item"></td>
          <td><input type="text" value="Auto-Filled Code" readonly></td>
          <td><input type="text" value="Auto-Filled Mfr Code" readonly></td>
          <td><input type="number" placeholder="Enter Qty"></td>
          <td><input type="number" value="0.00" readonly></td>
          <td><input type="text" value="Auto Stock" readonly></td>
          <td><input type="number" value="Auto Tax" readonly></td>
          <td><button type="button" class='remove-btn' onclick='removeRow(this)'>X</button></td>
        </tr> -->
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

  if (items.length === 0) {
    alert("Please add at least one item with quantity.");
    return;
  }

  const payload = { vendor, items };

  fetch('po_save.php', {
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

  if (items.length === 0) {
    alert("Please add at least one item with quantity.");
    return;
  }

  const payload = { vendor, items };

  fetch('sentoauth.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert("PO Send for Authorization successfully! PO Number: " + data.po_number);
      location.reload();
    } else {
      alert("Error saving PO: " + data.message);
    }
  });
}
</script>
</body>
</html>
