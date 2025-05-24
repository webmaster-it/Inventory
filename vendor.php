<?php
include 'header.php'
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 950px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 50px;}
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
    <h2>Vendor Master</h2>
    <form id="vendorForm" onsubmit="event.preventDefault(); saveVendor();">
      <label>Vendor Name</label>
      <input type="text" id="name" placeholder="Enter vendor name" required>

      <label>Senior Manager</label>
      <input type="text" id="senior_manager" placeholder="Name of Senior Manager">
      <label>Senior Manager Email</label>
      <input type="email" id="senior_email" placeholder="Senior Manager Email" multiple>
      <label>Senior Manager Phone</label>
      <input type="text" id="senior_phone" placeholder="Senior Manager Phone">

      <label>Account Manager</label>
      <input type="text" id="account_manager" placeholder="Name of Account Manager">
      <label>Account Manager Email</label>
      <input type="email" id="account_email" placeholder="Account Manager Email" multiple>
      <label>Account Manager Phone</label>
      <input type="text" id="account_phone" placeholder="Account Manager Phone">

      <label>PAN No</label>
      <input type="text" id="pan" placeholder="PAN Number">

      <label>GST No</label>
      <input type="text" id="gst" placeholder="GST Number">

      <label>Address</label>
      <textarea id="address" rows="2" placeholder="Address"></textarea>

      <label>Status</label>
      <select id="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>

      <button class="btn" type="submit">Save Vendor</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Senior Manager</th>
          <th>Sr. Email</th>
          <th>Sr. Phone</th>
          <th>Account Manager</th>
          <th>Acc. Email</th>
          <th>Acc. Phone</th>
          <th>PAN</th>
          <th>GST</th>
          <th>Status</th>
          <th>Last Updated</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody id="vendorTable"></tbody>
    </table>
  </div>

<script>
    let vendors = [];
let editIndex = -1;
document.addEventListener("DOMContentLoaded", function () {
    fetchVendors();
});

function fetchVendors() {
    fetch('vendor_fetch.php')
        .then(res => res.json())
        .then(data => {
            vendors = data;
            renderTable();
        });
}

function saveVendor() {
    const name = document.getElementById('name').value;
    const code = editIndex !== -1 ? vendors[editIndex].code : 'VEN' + String(vendors.length + 1).padStart(3, '0');
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? vendors[editIndex].id : '';

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("name", name);
    formData.append("senior_manager", document.getElementById('senior_manager').value);
    formData.append("senior_email", document.getElementById('senior_email').value);
    formData.append("senior_phone", document.getElementById('senior_phone').value);
    formData.append("account_manager", document.getElementById('account_manager').value);
    formData.append("account_email", document.getElementById('account_email').value);
    formData.append("account_phone", document.getElementById('account_phone').value);
    formData.append("pan", document.getElementById('pan').value);
    formData.append("gst", document.getElementById('gst').value);
    formData.append("address", document.getElementById('address').value);
    formData.append("status", status);

    fetch('vendor_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            clearForm();
            fetchVendors();
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
    const tableBody = document.getElementById('vendorTable');
    tableBody.innerHTML = '';

    vendors.forEach((v, index) => {
        tableBody.innerHTML += `
            <tr>
                <td>${v.code || ''}</td>
                <td>${v.name || ''}</td>
                <td>${v.senior_manager || ''}</td>
                <td>${v.senior_email || ''}</td>
                <td>${v.senior_phone || ''}</td>
                <td>${v.account_manager || ''}</td>
          <td>${v.account_email || ''}</td>
          <td>${v.account_phone || ''}</td>
          <td>${v.pan || ''}</td>
          <td>${v.gst || ''}</td>
                <td>${v.status || ''}</td>
                <td>${v.updated_at || ''}</td>
                <td><button onclick="editVendor(${index})">Edit</button></td>
            </tr>
        `;
    });
}

function editVendor(index) {
    const v = vendors[index];
    const code = document.getElementById('code')?.value || '';
    document.getElementById('name').value = v.name || '';
    document.getElementById('senior_manager').value = v.senior_manager || '';
    document.getElementById('senior_email').value = v.senior_email || '';
    document.getElementById('senior_phone').value = v.senior_phone || '';
    document.getElementById('account_manager').value = v.account_manager || '';
    document.getElementById('account_email').value = v.account_email || '';
    document.getElementById('account_phone').value = v.account_phone || '';
    document.getElementById('pan').value = v.pan || '';
    document.getElementById('gst').value = v.gst || '';
    document.getElementById('address').value = v.address || '';
    document.getElementById('status').value = v.status || 'Active';
    editIndex = index;
}
</script>

</body>
</html>
