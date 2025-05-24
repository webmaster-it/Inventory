<?php 
include("dbconnection.php");
$strEmployeeName  = $_SESSION['username'];
$strDesignation   = $_SESSION['role'];
$strEmplyeeID   = $_SESSION['user_code'];
if($strEmplyeeID == "")
{
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Store Dashboard</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f6f9fc; margin: 0; padding: 20px; }
    .container { max-width: 1200px; margin: auto; }
    h2 { margin-top: 0; }
    .cards { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px; }
    .card { flex: 1 1 200px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 6px rgba(0,0,0,0.05); }
    .card h3 { margin: 0; font-size: 18px; color: #555; }
    .card p { font-size: 24px; margin: 10px 0 0; color: #111; }

    .section { margin-bottom: 40px; }
    .section h3 { font-size: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 15px; }

    table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 0 6px rgba(0,0,0,0.05); }
    th, td { text-align: left; padding: 10px; border-bottom: 1px solid #eee; }
    th { background: #f0f0f0; }

    .quick-actions { display: flex; gap: 15px; margin-top: 20px; }
    .quick-actions button {
      padding: 10px 16px; border: none; border-radius: 6px;
      background: #3498db; color: white; cursor: pointer;
    }
    .quick-actions button:hover { background: #2980b9; }
  </style>
</head>

<body>
  <style>
    nav {
      background: #2c3e50;
      padding: 10px 30px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    nav .logo {
      font-size: 18px;
      font-weight: bold;
    }

    nav .nav-links {
      display: flex;
      gap: 20px;
      align-items: center;
    }

    .nav-link {
      color: white;
      text-decoration: none;
      padding: 8px 12px;
      border-radius: 6px;
      transition: background 0.3s;
    }

    .nav-link:hover {
      background: #34495e;
    }

    .dropdown {
      position: relative;
    }

    .dropdown > .nav-link::after {
      content: ' ▼';
      font-size: 10px;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      top: 24px;
      left: 0;
      background-color: #34495e;
      min-width: 200px;
      border-radius: 6px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .dropdown-content a {
      color: white;
      padding: 10px 16px;
      text-decoration: none;
      display: block;
      transition: background 0.2s;
    }

    .dropdown-content a:hover {
      background-color: #3e5a74;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }
  </style>

  
<nav>
  <div class="logo" style="display: flex; align-items: center; gap: 12px;">
   <a href="index.php"> <img src="Logo.png" alt="Logo" style="height: 30px;
    width: 80px;"></a>
    <div>
      <div style="font-size: 16px; font-weight: bold;">Inventory Software</div>
      <div style="font-size: 12px; font-weight: normal;"></div>
    </div>
  </div>
  <div class="nav-links">

    <div class="nav-links">
      <a href="index.php" class="nav-link">Dashboard</a>
      <div class="dropdown">
        <span class="nav-link">Masters</span>
        <div class="dropdown-content">
          <a href="item.php">Item Master</a>
          <a href="category.php">Category</a>
          <a href="subcategory.php">Subcategory</a>
          <a href="vendor.php">Vendor</a>
          <a href="manufacturer.php">Manufacturer</a>
          <a href="department.php">Department</a>
          <a href="unit.php">Unit</a>
          <a href="locationmaster.php">Storage Location</a>
          <a href="temperature.php">Temperature</a>
          <a href="staff.php">Staff</a>
          <a href="user_master.php">User</a>
          <a href="reasonmaster.php">Reason</a>
          <a href="itemlists.php">Item Lists</a>
          
        </div>
      </div>
      <div class="dropdown">
        <span class="nav-link">Transactions</span>
        <div class="dropdown-content">
          <a href="povendor.php">PO</a>
          <a href="po_draft.php">Pending PO</a>
          <a href="poauthorization.php">PO Authorization</a>
          <a href="grn.php">GRN</a>
          <a href="indent.php">Indent</a>
          <a href="issueindent.php">Issue</a>
          <a href="reorder_suggestions.php">Reorder Suggestions</a>
        </div>
      </div>
      <div class="dropdown">
        <span class="nav-link">Reports</span>
        <div class="dropdown-content">
          <a href="stockmanager.php">Stock Ledger</a>
          <a href="#">Reorder Items</a>
          <a href="#">Expiry Tracker</a>
          <a href="pogrn.php">GRN Report</a>
          <a href="#">Indent vs Issue</a>
        </div>
      </div>
      <a href="logout.php" class="nav-link">LogOut</a>
    </div>
  </nav>