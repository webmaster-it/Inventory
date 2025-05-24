<?php
include 'header.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 700px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);  margin-top: 50px;}
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
    <h2>Storage Location Master</h2>
    <form id="locationForm" onsubmit="event.preventDefault(); saveLocation();">
      <label>Location Name</label>
      <input type="text" id="name" placeholder="Enter location name" required>

      <label>Temperature Category</label>
<select id="temperature">
<option value="">Select Temperature</option>
<option value="Room">Room (15°C - 25°C)</option>
<option value="Fridge">Fridge (2°C - 8°C)</option>
<option value="Freezer">Freezer (-20°C)</option>
</select>

<label>Description (optional)</label>
      <textarea id="desc" rows="2" placeholder="Description"></textarea>

      <label>Status</label>
      <select id="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>

      <button class="btn" type="submit">Save Location</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Temperature</th><th>Description</th>
          <th>Status</th>
          <th>Last Updated</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody id="locationTable"></tbody>
    </table>
  </div>

<script>
let locations = [];
let editIndex = -1;

document.addEventListener("DOMContentLoaded", function () {
    fetchLocations();
});

function fetchLocations() {
    fetch('location_fetch.php')
        .then(res => res.json())
        .then(data => {
            locations = data;
            renderTable();
        });
}

function saveLocation() {
    const name = document.getElementById('name').value;
    const temperature_code = document.getElementById('temperature').value;
    const desc = document.getElementById('desc').value;
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? locations[editIndex].id : '';
    const code = editIndex !== -1 ? locations[editIndex].code : 'LOC' + String(locations.length + 1).padStart(3, '0');

    if (!name || !temperature_code) {
        alert("Please fill all required fields.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("name", name);
    formData.append("temperature_code", temperature_code);
    formData.append("description", desc);
    formData.append("status", status);

    fetch('location_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            document.getElementById('locationForm').reset();
            document.getElementById('status').value = 'Active';
            editIndex = -1;
            fetchLocations();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function renderTable() {
    const tableBody = document.getElementById('locationTable');
    tableBody.innerHTML = '';

    locations.forEach((loc, index) => {
        tableBody.innerHTML += `
            <tr>
                <td>${loc.code || ''}</td>
                <td>${loc.name || ''}</td>
                <td>${loc.temperature_code || ''}</td>
                <td>${loc.description || ''}</td>
                <td>${loc.status || ''}</td>
                <td>${loc.updated_at || ''}</td>
                <td><button onclick="editLocation(${index})">Edit</button></td>
            </tr>
        `;
    });
}

function editLocation(index) {
    const loc = locations[index];
    document.getElementById('name').value = loc.name || '';
    document.getElementById('temperature').value = loc.temperature_code || '';
    document.getElementById('desc').value = loc.description || '';
    document.getElementById('status').value = loc.status || 'Active';
    editIndex = index;
}
</script>

</body>
</html>
