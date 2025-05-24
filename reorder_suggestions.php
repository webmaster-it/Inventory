<?php
include 'header.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 30px; }
    .container { max-width: 1100px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 50px; }
    h2 { text-align: center; margin-bottom: 20px; }
    .filters { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px; }
    .filters select, .filters input { padding: 8px; width: 220px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background-color: #f0f0f0; cursor: pointer; }
    .btn { background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background: #2980b9; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Reorder Suggestions</h2>

    <div class="filters">
      <input type="text" placeholder="Search Item (Name / Code / Mfr Code)">
      <select>
        <option value="">Filter by Category</option>
        <option>Reagents</option>
        <option>Consumables</option>
      </select>
      <select>
        <option value="">Filter by Subcategory</option>
        <option>Blood Tests</option>
        <option>Urine Tests</option>
      </select>
      <select>
        <option value="">Filter by Manufacturer</option>
        <option>Thermo Fisher</option>
        <option>Roche</option>
      </select>
      <button class="btn">Apply</button>
    </div>

    <form>
      <table>
        <thead>
          <tr>
            <th>Select</th>
            <th>Item Name</th>
            <th>Internal Code</th>
            <th>Manufacturer Code</th>
            <th>Current Stock</th>
            <th>Pending PO</th>
            <th>Reorder Level</th>
            <th>Suggested Qty</th>
            <th>Primary Vendor</th>
            <th>Rate</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="checkbox"></td>
            <td>Syringe 5ml</td>
            <td>ITM001</td>
            <td>MF00123</td>
            <td>120</td>
            <td>30</td>
            <td>200</td>
            <td>50</td>
            <td>HealthSupplies Co.</td>
            <td>5.00</td>
          </tr>
        </tbody>
      </table>

      <button class="btn">Generate PO</button>
    </form>
  </div>
</body>
</html>
