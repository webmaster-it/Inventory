<?php
include 'header.php';
include 'dbconnection.php';
$result = $conn->query("SELECT po.id, po.po_number,item_master.name,item_master.code,poi.manufacturer_code,poi.qty,poi.rate,poi.tax,po.po_number,po.vendor_code,po.created_at,po.status FROM purchase_order po
INNER JOIN  purchase_order_item poi ON po.id  = poi.po_id INNER JOIN item_master ON item_master.code =poi.item_code WHERE poi.deleteitem='0' AND po.status='Pending Authorization'");
if(isset($_POST['authorized']))
  {
$strBookid     = $_POST['chktot'];
    $qty    = $_POST['qty'];
    
    $chkAdd = $_POST['chkAdd'];
    for($i=0; $i <sizeof($chkAdd); $i++)
    {
      $strChkSql = "select * from purchase_order where id = '".$chkAdd[$i]."'"; 
      $strQuery  = $conn->query($strChkSql);     
      $stBRow = mysqli_fetch_array($strQuery);
     // print_r($stBRow['po_id'][$i]);
     // echo "chk".$stBRow;
        $sqladdCatww = 'UPDATE purchase_order SET status="Authorized" WHERE id='.$chkAdd[$i];
        // print_r($sqladdCat);
        $rows1ww = $conn->query($sqladdCatww);
        $displaystr = "PO Authorized  successfully !! ";
    }
  }
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 30px; }
    .container { max-width: 1000px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { text-align: center; margin-bottom: 10px; }
    label { font-weight: bold; display: block; margin-top: 15px; }
    input[type="text"], input[type="number"] { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; vertical-align: middle; }
    th { background-color: #f0f0f0; }
    .btn { margin-top: 20px; background: #2c3e50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px; }
    .btn:hover { background: #1a252f; }
    .remove-btn { background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; }
    .remove-btn:hover { background: #c0392b; }
    .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .meta { margin-top: 10px; background: #f9f9f9; padding: 10px; border-radius: 6px; border: 1px solid #ccc; }
    .meta p { margin: 5px 0; font-size: 14px; }
  </style>
  <script>
    function removeRow(btn) {
      const row = btn.closest('tr');
      row.remove();
    }

    function deletePO() {
      if (confirm("Are you sure you want to delete the entire PO?")) {
        alert("PO deleted.");
      }
    }
  </script>
</head>
<body>
  <div class="container">
    <div class="header">
      <h2>Purchase Order Authorization</h2>

      <!-- <button class="remove-btn" onclick="deletePO()">Delete Entire PO</button> -->
    </div>

    <div class="meta">
      <p><strong>PO Reference No:</strong> PO-2024-00125</p>
      <p><strong>Created On:</strong> 2024-04-10 at 14:35</p>
      <p><strong>Created By:</strong> Ramesh Verma (Store Manager)</p>
      <p><strong>Department:</strong> Central Store</p>
    </div>
<h4 class="card-title" style="color: green;"><?php if($displaystr != "") echo $displaystr;?></h4>

 <form method="post" name="booking" action="" autocomplete="off">
    <table>
      <thead>
        <tr>
          <th></th>
          <th>PO Number</th>
          <th>Item</th>
          <th>Internal Code</th>
          <th>Manufacturer Code</th>
          <th>Quantity</th>
          <th>Rate</th>
          <th>Tax %</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody id="authTableBody">
        <?php
while($row = $result->fetch_assoc()) {
   // print_r($row);
      ?>
        <tr>
          <td><input type="hidden" name="chktot[]" value="<?=$row["id"]?>" /><input type="checkbox" name="chkAdd[]" value="<?=$row['id']?>"></td>
          <td><?php echo $row["po_number"]; ?></td>
          <td><?php echo $row["name"]; ?></td>
          <td><?php echo $row["code"]; ?></td>
          <td><?php echo $row["manufacturer_code"]; ?></td>
          <td><?php echo $row["qty"]; ?></td>
          <td><?php echo $row["rate"]; ?></td>
          <td><?php echo $row["tax"]; ?></td>
          <td><button class="remove-btn" onclick="removeRow(this)">X</button></td>
        </tr>
        <?php

      }?>
        
      </tbody>
    </table>

    <div style="text-align:center;">
      <button type="submit" class="btn" name="authorized">Finalize & Notify Vendor</button>
    </div>
  </form>
  </div>

<script>
function loadVendorPOItems(vendorCode) {
  fetch("authorizedss.php?vendor=" + vendorCode)
    .then(res => res.json())
    .then(items => {
      const tbody = document.getElementById("authTableBody");
      tbody.innerHTML = "";
      items.forEach(item => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${item.name}</td>
          <td>${item.code}</td>
          <td>${item.manufacturer_code}</td>
          <td><input type="number" value="0" min="0"></td>
          <td>${item.default_rate}</td>
          <td>${item.current_stock}</td>
          <td>${item.tax}%</td>
          <td><button class="remove-btn" onclick="removeRow(this)">X</button></td>
        `;
        tbody.appendChild(row);
      });
    });
}
</script>

</body>
</html>
