<?php
include 'header.php';
include 'dbconnection.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 800px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 50px;}
    h2 { text-align: center; font-size: 22px; }
    label { display: block; margin-top: 15px; font-weight: bold; font-size: 14px; }
    input, select, textarea { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; margin-top: 20px; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #f9f9f9; }
    .btn { margin-top: 20px; background: #3498db; color: white; padding: 10px 16px; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background: #2980b9; }
  </style>
  <script>
    let subcategories = [];
    let editIndex = -1;

    function saveSubcategory() {
      const name = document.getElementById('name').value;
      const parent = document.getElementById('parent').value;
      const parentName = document.getElementById('parent').selectedOptions[0].text;
      const desc = document.getElementById('desc').value;
      const status = document.getElementById('status').value;
      const timestamp = new Date().toLocaleString();

      if (!name || !parent) {
        alert("Please enter all required fields.");
        return;
      }

      if (editIndex === -1) {
        const newId = subcategories.length + 1;
        const code = parent + String(newId).padStart(2, '0');
        subcategories.push({ id: newId, code, name, parent, parentName, desc, status, updatedAt: timestamp });
      } else {
        subcategories[editIndex] = { ...subcategories[editIndex], name, parent, parentName, desc, status, updatedAt: timestamp };
        editIndex = -1;
      }

      document.getElementById('name').value = '';
      document.getElementById('parent').value = '';
      document.getElementById('desc').value = '';
      document.getElementById('status').value = 'Active';
      renderTable();
    }

    function renderTable() {
      const tableBody = document.getElementById('subcategoryTable');
      tableBody.innerHTML = '';

      subcategories.forEach((sub, index) => {
        tableBody.innerHTML += `
          <tr>
            <td>${sub.code}</td>
            <td>${sub.name}</td>
            <td>${sub.parentName}</td>
            <td>${sub.desc}</td>
            <td>${sub.status}</td>
            <td>${sub.updatedAt}</td>
            <td><button onclick="editSubcategory(${index})">Edit</button></td>
          </tr>
        `;
      });
    }

   function editSubcategory(index) {
    const sub = subcategories[index];
    document.getElementById('name').value = sub.name || '';
    document.getElementById('parent').value = sub.category_code || '';
    document.getElementById('desc').value = sub.description || '';
    document.getElementById('status').value = sub.status || 'Active';
    editIndex = index;
}

  </script>
</head>
<body>
  <div class="container">
    <h2>Subcategory Master</h2>

    <label for="parent">Parent Category</label>
    <select id="parent" required>
      <option value="">Select Category</option>
      <?php 
                                $sqlArea = "select code ,name from category_master";
                                $res = $conn->query($sqlArea);
                                while($area = mysqli_fetch_array($res))
                                {
                                  //print_r($area);
                                  //if($strBookingCat != ''){
                              ?>
                                                          <option class="<?=$area["code"]?> form-select" value="<?=$area["code"]?>">
                                                              
                                                            <?=$area["name"]?></option>
                                                            <?php } ?>
    </select>

    <label for="name">Subcategory Name</label>
    <input type="text" id="name" placeholder="Enter subcategory name" required>

    <label for="desc">Description (optional)</label>
    <textarea id="desc" rows="2" placeholder="Optional notes"></textarea>

    <label for="status">Status</label>
    <select id="status">
      <option value="Active">Active</option>
      <option value="Inactive">Inactive</option>
    </select>

    <button class="btn" onclick="saveSubcategory()">Save Subcategory</button>

    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Parent Category</th>
          <th>Description</th>
          <th>Status</th>
          <th>Last Updated</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody id="subcategoryTable"></tbody>
    </table>
  </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetchSubcategories();
});

function fetchSubcategories() {
    fetch('subcategory_fetch.php')
        .then(res => res.json())
        .then(data => {
            subcategories = data;
            renderTable();
        });
}

function saveSubcategory() {
    const name = document.getElementById('name').value;
    const parent = document.getElementById('parent').value;
    const parentName = document.getElementById('parent').selectedOptions[0].text;
    const desc = document.getElementById('desc').value;
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? subcategories[editIndex].id : '';
    const code = editIndex !== -1 ? subcategories[editIndex].code : parent + String(subcategories.length + 10).padStart(2, '0');

    if (!name || !parent) {
        alert("Please enter all required fields.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("name", name);
    formData.append("category_code", parent);
    formData.append("description", desc);
    formData.append("status", status);

    fetch('subcategory_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            document.getElementById('name').value = '';
            document.getElementById('parent').value = '';
            document.getElementById('desc').value = '';
            document.getElementById('status').value = 'Active';
            editIndex = -1;
            fetchSubcategories();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function renderTable() {
    const tableBody = document.getElementById('subcategoryTable');
    tableBody.innerHTML = '';

    subcategories.forEach((sub, index) => {
        tableBody.innerHTML += `
            <tr>
                <td>${sub.code || ''}</td>
                <td>${sub.name || ''}</td>
                <td>${sub.parent_name || ''}</td>
                <td>${sub.description || ''}</td>
                <td>${sub.status || ''}</td>
                <td>${sub.updated_at || ''}</td>
                <td><button onclick="editSubcategory(${index})">Edit</button></td>
            </tr>
        `;
    });
}
</script>

</body>
</html>
