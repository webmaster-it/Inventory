<?php
include 'header.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
    .container { max-width: 1100px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);  margin-top: 50px;}
    h2 { text-align: center; margin-bottom: 20px; }
    label { display: block; margin-top: 15px; font-weight: bold; }
    input, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background-color: #f0f0f0; }
    .btn { background: #3498db; color: white; padding: 8px 16px; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px; }
    .btn:hover { background: #2980b9; }
    .remove-btn { background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; }
  </style>
  <script>
    function toggleIndentMode(mode) {
      document.getElementById('selfSection').style.display = mode === 'self' ? 'block' : 'none';
      document.getElementById('otherSection').style.display = mode === 'others' ? 'block' : 'none';
    }

    function addRow() {
      const table = document.getElementById('indentTableBody');
      const row = table.insertRow();
      row.innerHTML = `
        <td><input type="text" placeholder="Search Item"></td>
        <td><input type="text" readonly value="ITMXXX"></td>
        <td><input type="text" readonly value="Chemicals"></td>
        <td><input type="number" placeholder="Qty"></td>
        <td><button type="button" class="remove-btn" onclick="removeRow(this)">X</button></td>
      `;
    }

    function removeRow(btn) {
      btn.closest('tr').remove();
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Create Indent</h2>

    <label>Indent Type</label>
    <select onchange="toggleIndentMode(this.value)">
      <option value="self">Indent for Self</option>
      <option value="others">Indent for Others</option>
    </select>

    <div id="selfSection">
      <label>Requesting User</label>
      <input type="text" value="Current User ID" readonly>
      <label>Department</label>
      <input type="text" value="Microbiology" readonly>
    </div>

    <div id="otherSection" style="display:none;">
      <label>Staff Name</label>
      <input type="text" placeholder="Enter staff name">
      <label>Department(s)</label>
      <input type="text" value="Auto Fetched Departments" readonly>
    </div>

    <label>Indent Date & Time</label>
    <input type="text" value="2025-04-10 16:30" readonly>

    <table>
      <thead>
        <tr>
          <th>Item</th>
          <th>Item Code</th>
          <th>Subcategory</th>
          <th>Quantity</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody id="indentTableBody">
        <tr>
          <td><input type="text" placeholder="Search Item"></td>
          <td><input type="text" readonly value="ITM001"></td>
          <td><input type="text" readonly value="Pipettes"></td>
          <td><input type="number" placeholder="Qty"></td>
          <td><button type="button" class="remove-btn" onclick="removeRow(this)">X</button></td>
        </tr>
      </tbody>
    </table>

    <button class="btn" onclick="addRow()">Add Row</button>
    <button class="btn">Save Indent</button>
  </div>

<script>
let indentItems = [];

document.addEventListener("DOMContentLoaded", function () {
    fetchIndents();
});

function fetchIndents() {
    fetch('indent_fetch.php')
        .then(res => res.json())
        .then(data => {
            console.log("Fetched Indents:", data);
            renderHistory(data);
        });
}

function addIndentRow() {
    const itemName = document.getElementById('itemName').value;
    const itemCode = document.getElementById('itemCode').value;
    const qty = document.getElementById('qty').value;

    if (!itemCode || !qty) {
        alert("Please fill item and quantity.");
        return;
    }

    indentItems.push({ item_code: itemCode, qty: parseInt(qty) });
    renderItemTable();
    document.getElementById('itemName').value = '';
    document.getElementById('itemCode').value = '';
    document.getElementById('qty').value = '';
}

function renderItemTable() {
    const table = document.getElementById('indentItemsTable');
    table.innerHTML = "";
    indentItems.forEach((item, index) => {
        table.innerHTML += `<tr>
            <td>${item.item_code}</td>
            <td>${item.qty}</td>
            <td><button onclick="removeItem(${index})">Remove</button></td>
        </tr>`;
    });
}

function removeItem(index) {
    indentItems.splice(index, 1);
    renderItemTable();
}

function saveIndent() {
    const indentor = document.getElementById('indentor_code').value;
    const requestedFor = document.getElementById('requested_for_code').value;
    const indentType = document.querySelector('input[name="indent_type"]:checked').value;

    const data = {
        indent_number: "IND" + new Date().getTime(),
        indent_type: indentType,
        indentor_code: indentor,
        requested_for_code: indentType === "On Behalf" ? requestedFor : indentor,
        items: indentItems
    };

    fetch('indent_save.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            alert("Indent saved successfully!");
            indentItems = [];
            renderItemTable();
            fetchIndents();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function renderHistory(data) {
    const historyTable = document.getElementById('indentHistory');
    historyTable.innerHTML = "";
    data.forEach((indent, idx) => {
        const itemList = indent.items.map(i => i.item_code + " (" + i.qty + ")").join(", ");
        historyTable.innerHTML += `<tr>
            <td>${indent.indent_number}</td>
            <td>${indent.indentor_code}</td>
            <td>${indent.requested_for_code}</td>
            <td>${indent.indent_type}</td>
            <td>${indent.indent_date}</td>
            <td>${indent.status}</td>
            <td>${itemList}</td>
        </tr>`;
    });
}
</script>

</body>
</html>
