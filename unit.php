<?php
include 'header.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 700px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);  margin-top: 50px;}
    h2 { text-align: center; font-size: 22px; }
    label { display: block; margin-top: 15px; font-weight: bold; font-size: 14px; }
    input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; margin-top: 20px; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #f9f9f9; }
    .btn { margin-top: 20px; background: #3498db; color: white; padding: 10px 16px; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background: #2980b9; }
  </style>
  
</head>
<body>
  <div class="container">
    <h2>Unit Master</h2>

    <label for="name">Unit Name</label>
    <input type="text" id="name" placeholder="Enter unit name" required>

    <label for="desc">Description (optional)</label>
    <textarea id="desc" rows="2" placeholder="Optional notes"></textarea>

    <label for="status">Status</label>
    <select id="status">
      <option value="Active">Active</option>
      <option value="Inactive">Inactive</option>
    </select>

    <button class="btn" onclick="saveUnit()">Save Unit</button>

    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Description</th>
          <th>Status</th>
          <th>Last Updated</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody id="unitTable"></tbody>
    </table>
  </div>

<script>
let units = [];
let editIndex = -1;

document.addEventListener("DOMContentLoaded", function () {
    fetchUnits();
});

function fetchUnits() {
    fetch('unit_fetch.php')
        .then(res => res.json())
        .then(data => {
            units = data;
            renderTable();
        });
}

function saveUnit() {
    const name = document.getElementById('name').value;
    const desc = document.getElementById('desc').value;
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? units[editIndex].id : '';
    const code = editIndex !== -1 ? units[editIndex].code : 'UNIT' + String(units.length + 1).padStart(3, '0');

    if (!name) {
        alert("Please enter unit name.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("name", name);
    formData.append("description", desc);
    formData.append("status", status);

    fetch('unit_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            document.getElementById('name').value = '';
            document.getElementById('desc').value = '';
            document.getElementById('status').value = 'Active';
            editIndex = -1;
            fetchUnits();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function renderTable() {
    const tableBody = document.getElementById('unitTable');
    tableBody.innerHTML = '';

    units.forEach((unit, index) => {
        tableBody.innerHTML += `
            <tr>
                <td>${unit.code || ''}</td>
                <td>${unit.name || ''}</td>
                <td>${unit.description || ''}</td>
                <td>${unit.status || ''}</td>
                <td>${unit.updated_at || ''}</td>
                <td><button onclick="editUnit(${index})">Edit</button></td>
            </tr>
        `;
    });
}

function editUnit(index) {
    const unit = units[index];
    document.getElementById('name').value = unit.name || '';
    document.getElementById('desc').value = unit.description || '';
    document.getElementById('status').value = unit.status || 'Active';
    editIndex = index;
}
</script>

</body>
</html>
