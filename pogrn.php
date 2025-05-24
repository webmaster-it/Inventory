<?php
include 'header.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
    .container { max-width: 1000px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);margin-top: 50px; }
    h2 { text-align: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #ccc; padding: 12px; text-align: center; }
    th { background-color: #f0f0f0; }
    .btn { background: #3498db; color: white; padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background: #2980b9; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Pending Purchase Orders for GRN</h2>
    <table>
      <thead>
        <tr>
          <th>PO No</th>
          <th>Vendor</th>
          <th>PO Date</th>
          <th>Status</th>
          <th>Created By</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>PO-2024-00125</td>
          <td>HealthSupplies Co.</td>
          <td>2024-04-05</td>
          <td>Partially Received</td>
          <td>Ramesh Verma</td>
          <td><button class="btn">Create GRN</button></td>
        </tr>
        <tr>
          <td>PO-2024-00128</td>
          <td>LabEquip Ltd.</td>
          <td>2024-04-07</td>
          <td>Open</td>
          <td>Seema Yadav</td>
          <td><button class="btn">Create GRN</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
