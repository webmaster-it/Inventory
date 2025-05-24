<?php
include 'header.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 800px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);  margin-top: 50px;}
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
    <h2>Manufacturer Master</h2>
    <form id="manufacturerForm" onsubmit="event.preventDefault(); saveManufacturer();">
      <label>Manufacturer Name</label>
      <input type="text" id="name" placeholder="Enter manufacturer name" required>

      <label>Senior Manager</label>
      <input type="text" id="seniorName" placeholder="Name of Senior Manager">
      <label>Senior Email</label>
      <input type="email" id="seniorEmail" placeholder="Senior Manager Email">
      <label>Senior Phone</label>
      <input type="text" id="seniorPhone" placeholder="Senior Manager Phone">

      <label>Account Manager</label>
      <input type="text" id="accountName" placeholder="Name of Account Manager">
      <label>Account Email</label>
      <input type="email" id="accountEmail" placeholder="Account Manager Email">
      <label>Account Phone</label>
      <input type="text" id="accountPhone" placeholder="Account Manager Phone">

      <label>Address</label>
      <textarea id="address" rows="2" placeholder="Address"></textarea>

      <label>Status</label>
      <select id="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>

      <button class="btn" type="submit">Save Manufacturer</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Sr. Manager</th><th>Sr. Email</th><th>Sr. Phone</th><th>Acc. Manager</th><th>Acc. Email</th><th>Acc. Phone</th>
          <th>Address</th>
          <th>Status</th>
          <th>Last Updated</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody id="manufacturerTable"></tbody>
    </table>
  </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetchManufacturers();
});
let manufacturers = [];
let editIndex = -1;
function fetchManufacturers() {
    fetch('manufacturer_fetch.php')
        .then(res => res.json())
        .then(data => {
            manufacturers = data;
            renderTable();
        });
}

function saveManufacturer() {
    const name = document.getElementById('name').value;
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? manufacturers[editIndex].id : '';
    const code = editIndex !== -1 ? manufacturers[editIndex].code : 'MFR' + String(manufacturers.length + 1).padStart(3, '0');

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("name", name);
    formData.append("senior_manager", document.getElementById('seniorName').value);
    formData.append("senior_email", document.getElementById('seniorEmail').value);
    formData.append("senior_phone", document.getElementById('seniorPhone').value);
    formData.append("account_manager", document.getElementById('accountName').value);
    formData.append("account_email", document.getElementById('accountEmail').value);
    formData.append("account_phone", document.getElementById('accountPhone').value);
    formData.append("address", document.getElementById('address').value);
    formData.append("status", status);

    fetch('manufacturer_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            clearForm();
            fetchManufacturers();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function clearForm() {
    document.querySelectorAll("input, textarea").forEach(el => el.value = '');
    document.getElementById('status').value = 'Active';
    editIndex = -1;
}

function renderTable() {
    const tableBody = document.getElementById('manufacturerTable');
    tableBody.innerHTML = '';

    manufacturers.forEach((mfr, index) => {
        tableBody.innerHTML += `
            <tr>
                <td>${mfr.code || ''}</td>
                <td>${mfr.name || ''}</td>
                <td>${mfr.senior_manager || ''}</td>
                <td>${mfr.senior_email || ''}</td>
                <td>${mfr.senior_phone || ''}</td>
                <td>${mfr.account_manager || ''}</td>
                <td>${mfr.account_email || ''}</td>
                <td>${mfr.account_phone || ''}</td>
                <td>${mfr.address || ''}</td>
                <td>${mfr.status || ''}</td>
                <td>${mfr.updated_at || ''}</td>
                <td><button onclick="editManufacturer(${index})">Edit</button></td>
            </tr>
        `;
    });
}

function editManufacturer(index) {
    const mfr = manufacturers[index];
    document.getElementById('name').value = mfr.name || '';
    document.getElementById('seniorName').value = mfr.senior_manager || '';
    document.getElementById('seniorEmail').value = mfr.senior_email || '';
    document.getElementById('seniorPhone').value = mfr.senior_phone || '';
    document.getElementById('accountName').value = mfr.account_manager || '';
    document.getElementById('accountEmail').value = mfr.account_email || '';
    document.getElementById('accountPhone').value = mfr.account_phone || '';
    document.getElementById('address').value = mfr.address || '';
    document.getElementById('status').value = mfr.status || 'Active';
    editIndex = index;
}
</script>
</body>
</html>
