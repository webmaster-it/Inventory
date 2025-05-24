<?php
include 'header.php';
?>
  <div class="container">
    <h2>Store Manager Dashboard</h2>

    <div class="cards">
      <div class="card">
        <h3>Items Below Reorder</h3>
        <p>12</p>
      </div>
      <div class="card">
        <h3>POs Pending Authorization</h3>
        <p>4</p>
      </div>
      <div class="card">
        <h3>GRNs Needing Review</h3>
        <p>2</p>
      </div>
      <div class="card">
        <h3>Indents Awaiting Issue</h3>
        <p>8</p>
      </div>
      <div class="card">
        <h3>Items Expiring Soon</h3>
        <p>5</p>
      </div>
    </div>

    <div class="quick-actions">
      <button>+ New PO</button>
      <button>+ New GRN</button>
      <button>+ New Indent</button>
      <button>+ New Issue</button>
    </div>

    <div class="section">
      <h3>Pending POs</h3>
      <table>
        <thead>
          <tr>
            <th>PO Number</th>
            <th>Vendor</th>
            <th>Status</th>
            <th>Created Date</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>PO2025003</td><td>Agilent Life</td><td>Pending Authorization</td><td>2025-04-09</td></tr>
          <tr><td>PO2025002</td><td>Siemens</td><td>Partial GRN</td><td>2025-04-08</td></tr>
        </tbody>
      </table>
    </div>

    <div class="section">
      <h3>Open Indents</h3>
      <table>
        <thead>
          <tr>
            <th>Indent No.</th>
            <th>Raised By</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>IND456</td><td>Dr. Sharma</td><td>Not Issued</td><td>2025-04-10</td></tr>
          <tr><td>IND455</td><td>Technician Ravi</td><td>Partially Issued</td><td>2025-04-09</td></tr>
        </tbody>
      </table>
    </div>

    <div class="section">
      <h3>Items Expiring Soon</h3>
      <table>
        <thead>
          <tr>
            <th>Item</th>
            <th>Batch</th>
            <th>Expiry Date</th>
            <th>Stock Qty</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>HIV Reagent A</td><td>R4567</td><td>2025-04-25</td><td>3</td></tr>
          <tr><td>CRP Kit</td><td>CRP-12X</td><td>2025-05-01</td><td>5</td></tr>
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>
