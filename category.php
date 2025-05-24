  <?php 
include 'header.php';
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { max-width: 700px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 50px; }
    h2 { text-align: center; font-size: 22px; }
    label { display: block; margin-top: 15px; font-weight: bold; font-size: 14px; }
    input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; margin-top: 20px; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #f9f9f9; }
    .btn { margin-top: 20px; background: #3498db; color: white; padding: 10px 16px; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background: #2980b9; }
  </style>
  <script>
    let categories = [];
    let editIndex = -1;

    function saveCategory() {
      const name = document.getElementById('name').value;
      const desc = document.getElementById('desc').value;
      const status = document.getElementById('status').value;
      const timestamp = new Date().toLocaleString();

      if (!name) {
        alert("Please enter category name.");
        return;
      }

      if (editIndex === -1) {
        const newId = categories.length + 1;
        const code = String(newId + 9).padStart(2, '0');  // 10, 11, ...
        categories.push({ id: newId, code, name, desc, status, updatedAt: timestamp });
      } else {
        categories[editIndex] = { ...categories[editIndex], name, desc, status, updatedAt: timestamp };
        editIndex = -1;
      }

      document.getElementById('name').value = '';
      document.getElementById('desc').value = '';
      document.getElementById('status').value = 'Active';
      renderTable();
    }

   function renderTable() {
  const tableBody = document.getElementById('categoryTable');
  tableBody.innerHTML = '';

  categories.forEach((cat, index) => {
    tableBody.innerHTML += `
      <tr>
        <td>${cat.code || ''}</td>
        <td>${cat.name || ''}</td>
        <td>${cat.description || ''}</td>
        <td>${cat.status || ''}</td>
        <td>${cat.updated_at || ''}</td>
        <td><button onclick="editCategory(${index})">Edit</button></td>
      </tr>
    `;
  });
}


    function editCategory(index) {
      const cat = categories[index];
      document.getElementById('name').value = cat.name;
      document.getElementById('desc').value = cat.description;
      document.getElementById('status').value = cat.status;
      editIndex = index;
    }
  </script>
  <div class="container">
    <h2>Category Master</h2>

    <label for="name">Category Name</label>
    <input type="text" id="name" placeholder="Enter category name" required>

    <label for="desc">Description (optional)</label>
    <textarea id="desc" rows="2" placeholder="Optional notes"></textarea>

    <label for="status">Status</label>
    <select id="status">
      <option value="Active">Active</option>
      <option value="Inactive">Inactive</option>
    </select>

    <button class="btn" onclick="saveCategory()">Save Category</button>

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
      <tbody id="categoryTable"></tbody>
    </table>
  </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetchCategories();
});

function fetchCategories() {
    fetch('category_fetch.php')
        .then(res => res.json())
        .then(data => {
            categories = data;
            renderTable();
        });
}

function saveCategory() {
    const name = document.getElementById('name').value;
    const desc = document.getElementById('desc').value;
    const status = document.getElementById('status').value;
    const id = editIndex !== -1 ? categories[editIndex].id : '';
    const code = editIndex !== -1 ? categories[editIndex].code : String(categories.length + 10).padStart(2, '0');

    if (!name) {
        alert("Please enter category name.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("code", code);
    formData.append("name", name);
    formData.append("description", desc);
    formData.append("status", status);

    fetch('category_save.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(response => {
        if (response.success) {
            document.getElementById('name').value = '';
            document.getElementById('desc').value = '';
            document.getElementById('status').value = 'Active';
            editIndex = -1;
            fetchCategories();
        } else {
            alert("Error: " + response.message);
        }
    });
}
</script>

</body>
</html>
