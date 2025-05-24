  <?php 
include 'header.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 700px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);  margin-top: 50px; }
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
    <h2>Department Master</h2>

    <label for="name">Department Name</label>
    <input type="text" id="name" placeholder="Enter department name" required>

    <label for="desc">Description (optional)</label>
    <textarea id="desc" rows="2" placeholder="Optional notes"></textarea>

    <label for="status">Status</label>
    <select id="status">
      <option value="Active">Active</option>
      <option value="Inactive">Inactive</option>
    </select>

    <button class="btn" onclick="saveDepartment()">Save Department</button>

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
      <tbody id="departmentTable"></tbody>
    </table>
  </div>

<script>
let departments = [];
let editIndex = -1;
document.addEventListener("DOMContentLoaded", function () {
    fetchDepartments();
});

function fetchDepartments() {
    fetch('department_fetch.php')
        .then(res => res.json())
        .then(data => {
            departments = data;
            renderTable();
        });
}

function saveDepartment() {
    const name = document.getElementById('name').value;
    const desc = document.getElementById('desc').value;
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? departments[editIndex].id : '';
    const code = editIndex !== -1 ? departments[editIndex].code : String(departments.length + 10).padStart(2, '0');

    if (!name) {
        alert("Please enter department name.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("name", name);
    formData.append("description", desc);
    formData.append("status", status);

    fetch('department_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            document.getElementById('name').value = '';
            document.getElementById('desc').value = '';
            document.getElementById('status').value = 'Active';
            editIndex = -1;
            fetchDepartments();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function renderTable() {
    const tableBody = document.getElementById('departmentTable');
    tableBody.innerHTML = '';

    departments.forEach((dept, index) => {
        tableBody.innerHTML += `
            <tr>
                <td>${dept.code || ''}</td>
                <td>${dept.name || ''}</td>
                <td>${dept.description || ''}</td>
                <td>${dept.status || ''}</td>
                <td>${dept.updated_at || ''}</td>
                <td><button onclick="editDepartment(${index})">Edit</button></td>
            </tr>
        `;
    });
}

function editDepartment(index) {
    const dept = departments[index];
    document.getElementById('name').value = dept.name || '';
    document.getElementById('desc').value = dept.description || '';
    document.getElementById('status').value = dept.status || 'Active';
    editIndex = index;
}
</script>

</body>
</html>
