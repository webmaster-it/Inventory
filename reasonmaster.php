<?php
include 'header.php';

?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 700px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 50px;}
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
    <h2>Reason Master</h2>
    <form id="reasonForm" onsubmit="event.preventDefault(); saveReason();">
      <label>Reason Name</label>
      <input type="text" id="name" placeholder="e.g. Expired, Damaged, Theft" required>

      <label>Description (optional)</label>
      <textarea id="desc" rows="2" placeholder="Additional notes..."></textarea>

      <label>Status</label>
      <select id="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>

      <button class="btn" type="submit">Save Reason</button>
    </form>

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
      <tbody id="reasonTable"></tbody>
    </table>
  </div>

<script>
let reasons = [];
let editIndex = -1;

document.addEventListener("DOMContentLoaded", function () {
    fetchReasons();
});

function fetchReasons() {
    fetch('reason_fetch.php')
        .then(res => res.json())
        .then(data => {
            reasons = data;
            renderTable();
        });
}

function saveReason() {
    const name = document.getElementById('name').value;
    const desc = document.getElementById('desc').value;
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? reasons[editIndex].id : '';
    const code = editIndex !== -1 ? reasons[editIndex].code : 'RSN' + String(reasons.length + 1).padStart(3, '0');

    if (!name) {
        alert("Please enter a reason name.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("name", name);
    formData.append("description", desc);
    formData.append("status", status);

    fetch('reason_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            document.getElementById('reasonForm').reset();
            document.getElementById('status').value = 'Active';
            editIndex = -1;
            fetchReasons();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function renderTable() {
    const tableBody = document.getElementById('reasonTable');
    tableBody.innerHTML = '';

    reasons.forEach((r, index) => {
        tableBody.innerHTML += `
            <tr>
                <td>${r.code || ''}</td>
                <td>${r.name || ''}</td>
                <td>${r.description || ''}</td>
                <td>${r.status || ''}</td>
                <td>${r.updated_at || ''}</td>
                <td><button onclick="editReason(${index})">Edit</button></td>
            </tr>
        `;
    });
}

function editReason(index) {
    const r = reasons[index];
    document.getElementById('name').value = r.name || '';
    document.getElementById('desc').value = r.description || '';
    document.getElementById('status').value = r.status || 'Active';
    editIndex = index;
}
</script>

</body>
</html>
