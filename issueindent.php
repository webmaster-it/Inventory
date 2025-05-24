<?php
include 'header.php';
?>

  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
    .container { max-width: 1100px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 50px; }
    h2 { text-align: center; margin-bottom: 20px; }
    label { display: block; margin-top: 15px; font-weight: bold; }
    input, select, textarea { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; vertical-align: middle; }
    th { background-color: #f0f0f0; }
    .btn { background: #2c3e50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px; }
    .btn:hover { background: #1a252f; }
    .remove-btn { background: #e74c3c; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; }
    .note { background: #f9f9f9; border-left: 5px solid #ccc; padding: 10px; margin-top: 15px; font-size: 12px; color: #333; }
  </style>
  <script>
    function removeRow(btn) {
      btn.closest('tr').remove();
    }
  </script>
</head>
<body>
  <div class="container">
    <h2 style='font-size: 22px;'>Issue Items from Indent</h2>

    <label style='font-size: 14px;'>Indent No.</label>
    <input type="text" value="IND-2024-00456" readonly>

    <label style='font-size: 14px;'>Requesting Staff</label>
    <input type="text" value="Dr. Anjali Sharma" readonly>

    <label style='font-size: 14px;'>Department</label>
    <input type="text" value="Biochemistry" readonly>

    <label style='font-size: 14px;'>Indent Date & Time</label>
    <input type="text" value="2025-04-10 16:15" readonly>

    <div class="note">
      Note: Only one batch can be issued per item from this screen. For multi-batch issuing, please create another issue from the same indent using the pending quantity.
    </div>

    <table>
      <thead>
        <tr>
          <th style='font-size: 13px;'>Item</th>
          <th style='font-size: 13px;'>Subcategory</th>
          <th style='font-size: 13px;'>Requested Qty</th>
          <th style='font-size: 13px;'>Available Qty</th>
          <th style='font-size: 13px;'>Batch (Default FIFO)</th>
          <th style='font-size: 13px;'>Issue Qty</th>
          <th style='font-size: 13px;'>Remove</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style='font-size: 13px;'>Test Tube</td>
          <td style='font-size: 13px;'>Glassware</td>
          <td style='font-size: 13px;'>30</td>
          <td style='font-size: 13px;'>120</td>
          <td style='font-size: 13px;'>
            <select>
              <option>BTCH001 - Exp: 2025-09 (Stock: 15)</option>
              <option>BTCH002 - Exp: 2026-01 (Stock: 100)</option>
            </select>
          </td>
          <td style='font-size: 13px;'><input type="number" value="30"></td>
          <td style='font-size: 13px;'><button type="button" class="remove-btn" onclick="removeRow(this)">X</button></td>
        </tr>
      </tbody>
    </table>

    <label style='font-size: 14px;'>Issue Remarks (optional)</label>
    <textarea rows="3" placeholder="Reason or additional notes"></textarea>

    <button class="btn">Confirm & Issue Items</button>
  </div>
</body>
</html>
