<?php
include 'header.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 950px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 50px;}
    h2 { text-align: center; font-size: 22px; }
    label { display: block; margin-top: 10px; font-weight: bold; font-size: 14px; }
    input, select, textarea { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; margin-top: 20px; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; font-size: 13px; }
    th { background: #f9f9f9; }
    .btn { margin-top: 20px; background: #3498db; color: white; padding: 10px 16px; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background: #2980b9; }
  </style>
  
</head>
<body>
  <div class="container">
    <h2>Staff Master</h2>
    <form id="staffForm" onsubmit="event.preventDefault(); saveStaff();">
      <label>Staff Name</label>
      <input type="text" id="name" placeholder="Enter staff name" required>

      <label>Role / Designation</label>
      <select id="role">
<option value="">Select Role</option>
<option value="Technician">Technician</option>
<option value="Pathologist">Pathologist</option>
<option value="Store Manager">Store Manager</option>
<option value="Admin">Admin</option>
</select>

      <label>Contact</label>
      <input type="text" id="contact" placeholder="Phone or Email">

      <label>Department</label>
      <select id="departments" required>
<option value="Hematology">Hematology</option>
<option value="Microbiology">Microbiology</option>
<option value="Biochemistry">Biochemistry</option>
<option value="Store">Store</option>
<option value="Serology">Serology</option>
</select>

      <label>Linked User ID (if applicable)</label>
      <select id="linked_user_code">
<option value="">Select Linked User</option>
<option value="USR001">USR001 - Rajeev</option>
<option value="USR002">USR002 - Shweta</option>
</select>

      <label>Status</label>
      <select id="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>

      <button class="btn" type="submit">Save Staff</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Role</th>
          <th>Contact</th>
          <th>Department</th>
          <th>Linked User</th>
          <th>Status</th>
          <th>Last Updated</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody id="staffTable"></tbody>
    </table>
  </div>

<script>
let staffList = [];
let editIndex = -1;

document.addEventListener("DOMContentLoaded", function () {
    fetchStaff();
});

function fetchStaff() {
    fetch('staff_fetch.php')
        .then(res => res.json())
        .then(data => {
            staffList = data;
            renderTable();
        });
}

function saveStaff() {
    const name = document.getElementById('name').value;
    const role = document.getElementById('role').value;
    const contact = document.getElementById('contact').value;
    const departments = document.getElementById('departments').value;
    const linked_user_code = document.getElementById('linked_user_code').value;
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? staffList[editIndex].id : '';
    const code = editIndex !== -1 ? staffList[editIndex].code : 'STF' + String(staffList.length + 1).padStart(3, '0');

    if (!name) {
        alert("Please fill required fields.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("name", name);
    formData.append("role", role);
    formData.append("contact", contact);
    formData.append("departments", departments);
    formData.append("linked_user_code", linked_user_code);
    formData.append("status", status);

    fetch('staff_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            document.getElementById('staffForm').reset();
            document.getElementById('status').value = 'Active';
            editIndex = -1;
            fetchStaff();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function renderTable() {
    const tableBody = document.getElementById('staffTable');
    tableBody.innerHTML = '';

    staffList.forEach((s, index) => {
        tableBody.innerHTML += `
            <tr>
                <td>${s.code || ''}</td>
                <td>${s.name || ''}</td>
                <td>${s.role || ''}</td>
                <td>${s.contact || ''}</td>
                <td>${s.departments || ''}</td>
                <td>${s.linked_user_code || ''}</td>
                <td>${s.status || ''}</td>
                <td>${s.updated_at || ''}</td>
                <td><button onclick="editStaff(${index})">Edit</button></td>
            </tr>
        `;
    });
}

function editStaff(index) {
    const s = staffList[index];
    document.getElementById('name').value = s.name || '';
    document.getElementById('role').value = s.role || '';
    document.getElementById('contact').value = s.contact || '';
    document.getElementById('linked_user_code').value = s.linked_user_code || '';
    document.getElementById('status').value = s.status || 'Active';

    const deptVals = s.departments ? s.departments.split(',') : [];
    document.querySelectorAll('input[name="departments"]').forEach(el => {
        el.checked = deptVals.includes(el.value);
    });

    editIndex = index;
}
</script>

</body>
</html>
