<?php
include 'header.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 750px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 50px;}
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
    <h2>Temperature Master</h2>
    <form id="temperatureForm" onsubmit="event.preventDefault(); saveTemperature();">
      <label>Temperature Name</label>
      <input type="text" id="name" placeholder="e.g. Room, Fridge, Freezer" required>

      <label>Temperature Range (°C)</label>
      <div style="display: flex; gap: 10px;">
        <input type="number" id="minTemp" placeholder="Min °C" required>
        <input type="number" id="maxTemp" placeholder="Max °C" required>
      </div>

      <label>Status</label>
      <select id="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>

      <button class="btn" type="submit">Save Temperature</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Range</th>
          <th>Status</th>
          <th>Last Updated</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody id="temperatureTable"></tbody>
    </table>
  </div>

<script>
let temperatures = [];
let editIndex = -1;

document.addEventListener("DOMContentLoaded", function () {
    fetchTemperatures();
});

function fetchTemperatures() {
    fetch('temperature_fetch.php')
        .then(res => res.json())
        .then(data => {
            temperatures = data;
            renderTable();
        });
}

function saveTemperature() {
    const name = document.getElementById('name').value;
    const min_celsius = document.getElementById('minTemp').value;
    const max_celsius = document.getElementById('maxTemp').value;
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? temperatures[editIndex].id : '';
    const code = editIndex !== -1 ? temperatures[editIndex].code : 'TMP' + String(temperatures.length + 1).padStart(3, '0');

    if (!name || min_celsius === '' || max_celsius === '') {
        alert("Please fill all required fields.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("name", name);
    formData.append("min_celsius", min_celsius);
    formData.append("max_celsius", max_celsius);
    formData.append("status", status);

    fetch('temperature_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            document.getElementById('temperatureForm').reset();
            document.getElementById('status').value = 'Active';
            editIndex = -1;
            fetchTemperatures();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function renderTable() {
    const tableBody = document.getElementById('temperatureTable');
    tableBody.innerHTML = '';

    temperatures.forEach((t, index) => {
        tableBody.innerHTML += `
            <tr>
                <td>${t.code || ''}</td>
                <td>${t.name || ''}</td>
                <td>${t.min_celsius}°C - ${t.max_celsius}°C</td>
                <td>${t.status || ''}</td>
                <td>${t.updated_at || ''}</td>
                <td><button onclick="editTemperature(${index})">Edit</button></td>
            </tr>
        `;
    });
}

function editTemperature(index) {
    const t = temperatures[index];
    document.getElementById('name').value = t.name || '';
    document.getElementById('minTemp').value = t.min_celsius || '';
    document.getElementById('maxTemp').value = t.max_celsius || '';
    document.getElementById('status').value = t.status || 'Active';
    editIndex = index;
}
</script>

</body>
</html>
