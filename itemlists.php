<?php
include 'header.php';
include 'dbconnection.php';
$result = $conn->query("SELECT i.code AS `Item Code`,
  i.name AS `Item Name`,
  i.manufacturer_code AS `Mfg Code`,
  i.manufacturer AS `Manufact`,
  i.default_vendor AS `Vendor`,
  i.storage_temp AS `Storage Temp`,
  i.testname AS `Tests Names`,
  i.storage_location AS `Storage Loc`,
  m.name AS `Mfg Name`,
  l.name AS `Location`,
  i.purchase_unit AS `Per. Unit`,
  i.issue_unit AS `Iss. Unit`,
  i.conversion_factor AS `Conv. Factor`,
  i.pack_size AS `Pack Size`,
  i.default_rate AS `Rate`,
  v.name AS `Pimary Suppl.`,
  sc.name AS `Test Name`,
  t.name AS `Temp`,
  uni.name AS `Purcha Name`

FROM item_master i
LEFT JOIN manufacturer_master m ON i.manufacturer = m.code
LEFT JOIN location_master l ON i.storage_location = l.code
LEFT JOIN vendor_master v ON i.default_vendor = v.code
LEFT JOIN subcategory_master sc ON i.subcategory_code = sc.code
LEFT JOIN unit_master uni ON i.purchase_unit = uni.code
LEFT JOIN temperature_master t ON i.storage_temp = t.code");



?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);  margin-top: 50px;}
    h2 { text-align: center; font-size: 22px; }
    label { display: block; margin-top: 10px; font-weight: bold; font-size: 14px; }
    input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; margin-top: 20px; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; font-size: 13px; }
    th { background: #f9f9f9; }
    .btn { margin-top: 20px; background: #3498db; color: white; padding: 10px 16px; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background: #2980b9; }
  </style>
 
</head>
<body>
  <div class="container">
    <h2>Item Lists</h2>
    
    <table>
      <thead>
        <tr>
          <th>Item Code</th>
          <th>Item Name</th>
          <th>Mfg Code</th>
          <th>Mfg Name</th>
          <th>Location</th>
          <th>Pur. Unit</th>
          <th>Iss. Unit</th>
          <th>Conv. Factor</th>
          <th>Pack Size</th>
          <th>Rate</th>
          <th>Pimary Suppl.</th>
          <th>Test Name</th>
          <th>Temp</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody></tbody>
      <?php
while($row = $result->fetch_assoc()) {
   // print_r($row);
      ?>
      <tr>
          <td><?php echo $row["Item Code"]; ?></td>
          <td><?php echo $row["Item Name"]; ?></td>
          <td><?php echo $row["Mfg Code"]; ?></td>
          <td><?php echo $row["Manufact"]; ?></td>
          <td><?php echo $row["Storage Loc"]; ?></td>
          <td><?php echo $row["Purcha Name"]; ?></td>
          <td><?php echo $row["Iss. Unit"]; ?></td>
          <td><?php echo $row["Conv. Factor"]; ?></td>
          <td><?php echo $row["Pack Size"]; ?></td>
          <td><?php echo $row["Rate"]; ?></td>
          <td><?php echo $row["Vendor"]; ?></td>
          <td><?php echo $row["Tests Names"]; ?></td>
          <td><?php echo $row["Storage Temp"]; ?></td>
          <td><a href="modifyitem.php?id=<?php echo $row["Item Code"]; ?>" target="_blank">Modify</td>
      </tr>
      <?php
  }
  ?>
    </table>
  </div>

</body>
</html>
