<?php
include 'header.php';
$servername1 = "localhost";
$username1 = "root";
$password1 = "";
$dbname1 = "creoianw_bhasin";

// Create connection
$conn1 = new mysqli($servername1, $username1, $password1, $dbname1);
 $sqlQueryert="SELECT * FROM tblemployee WHERE status='1' order by empname ASC";
                        //print_r($sqlQuery);
                         $strResert   = $conn1->query($sqlQueryert);

?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 800px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);  margin-top: 50px;}
    h2 { text-align: center; font-size: 22px; }
    label { display: block; margin-top: 10px; font-weight: bold; font-size: 14px; }
    input, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; margin-top: 20px; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; font-size: 13px; }
    th { background: #f9f9f9; }
    .btn { margin-top: 20px; background: #3498db; color: white; padding: 10px 16px; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background: #2980b9; }
  </style>
  
</head>
<body>
  <div class="container">
    <h2>User Master</h2>
    <form id="userForm" onsubmit="event.preventDefault(); saveUser();">
      <label>Linked Staff Code</label>
      <select id="staff_code">
        <option value="">Select Staff</option>
        <?php
        while($strRow = mysqli_fetch_array($strResert))
                                                        {
                                                    ?>
                                                    <option value="<?=$strRow["empname"]?>"><?=$strRow["empname"]?></option>
                                                    <?php } ?>
      </select>

      <label>Username</label>
      <input type="text" id="username" placeholder="Create a login username" required>

      <label>Password</label>
      <input type="password" id="password" placeholder="Password" required>

      <label>Role</label>
      <select id="role">
        <option value="Indentor">Indentor</option>
        <option value="Authorizer">Authorizer</option>
        <option value="Store Manager">Store Manager</option>
        <option value="Admin">Admin</option>
      </select>

      <label>Status</label>
      <select id="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>

      <button class="btn" type="submit">Save User</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>User Code</th>
          <th>Staff Code</th>
          <th>Username</th>
          <th>Role</th>
          <th>Status</th>
          <th>Last Updated</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody id="userTable"></tbody>
    </table>
  </div>

<script>
let users = [];
let editIndex = -1;
document.addEventListener("DOMContentLoaded", function () {
    fetchUsers();
});

function fetchUsers() {
    fetch('user_fetch.php')
        .then(res => res.json())
        .then(data => {
            users = data;
            renderTable();
        });
}

function saveUser() {
    const staff_code = document.getElementById('staff_code').value;
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? users[editIndex].id : '';
    const code = editIndex !== -1 ? users[editIndex].code : 'USR' + String(users.length + 1).padStart(3, '0');

    if (!username || !password) {
        alert("Please enter both username and password.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("staff_code", staff_code);
    formData.append("username", username);
    formData.append("password", password);
    formData.append("role", role);
    formData.append("status", status);

    fetch('user_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            document.getElementById('userForm').reset();
            document.getElementById('status').value = 'Active';
            editIndex = -1;
            fetchUsers();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function renderTable() {
    const tableBody = document.getElementById('userTable');
    tableBody.innerHTML = '';

    users.forEach((user, index) => {
        tableBody.innerHTML += `
            <tr>
                <td>${user.code || ''}</td>
            <td>${user.staff_code || ''}</td>
                <td>${user.username || ''}</td>
                <td>${user.role || ''}</td>
                <td>${user.status || ''}</td>
                <td>${user.updated_at || ''}</td>
                <td><button onclick="editUser(${index})">Edit</button></td>
            </tr>
        `;
    });
}

function editUser(index) {
    const u = users[index];
    document.getElementById('staff_code').value = u.staff_code || '';
    document.getElementById('username').value = u.username || '';
    document.getElementById('password').value = ''; // password not shown
    document.getElementById('role').value = u.role || '';
    document.getElementById('status').value = u.status || 'Active';
    editIndex = index;
}
</script>

</body>
</html>
