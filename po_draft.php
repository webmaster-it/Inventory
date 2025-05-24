<?php
include 'header.php';
include 'dbconnection.php';
$result = $conn->query("SELECT po.po_number,po.vendor_code,SUM(poi.rate) AS rest,po.created_at,po.status FROM purchase_order po
INNER JOIN  purchase_order_item poi ON po.id  = poi.po_id GROUP BY poi.po_id");
if (isset($_POST['submit'])) {
  $ponumber=$_POST['ponumber'];
  $updateQuery = 'UPDATE purchase_order SET status = "Closed",grnupdate="GRN" WHERE po_number = "'.$ponumber.'"';
   $rowsnew = $conn->query($updateQuery);
   //header("Location: grn.php?id=$ponumber");
}
?>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
    .container { margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);  margin-top: 50px;}
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
    <h2>Pending Po Lists</h2>
    
    <table>
      <thead>
        <tr>
          <th>PO Number/Date</th>
          <th>Supplier Name</th>
          <th>Total Amount</th>
          <th>Pending Amount</th>
          <th>Status</th>
          <th>Action</th>
          <th>Send</th>
        </tr>
      </thead>
      <tbody></tbody>
      
      <?php
while($row = $result->fetch_assoc()) {
   // print_r($row);
      ?>
      <tr>
          <td><?php echo $row["po_number"].'/'. $row["created_at"]; ?></td>
          <td><?php echo $row["vendor_code"]; ?></td>
          <td><?php echo $row["rest"]; ?></td>
          <td><?php echo $row[""]; ?></td>
          <td><?php echo $row["status"]; ?></td>
        <?php if ($row["status"]=="Authorized") {
          ?>
    <td><form method="post" action=""><input type="hidden" name="ponumber" value="<?php echo $row["po_number"]; ?>"><button type="submit" name="submit">GRN</button></td></form>
          <?php
          }elseif($row["status"]=="Pending Authorization"){ ?>
         <td> <a href="posuthori.php?id=<?php echo $row["po_number"]; ?>" target="_blank">Modify /  </a><a href="poauthentication.php?id=<?php echo $row["po_number"]; ?>" target="_blank">Authorized</a></td>
         <?php
       }elseif($row["status"]=="Closed"){ ?>
         <td> <a href="grn.php?id=<?php echo $row["po_number"]; ?>" target="_blank">Modify   </a></td>
         <?php
       }else{
       ?>
       <td> <a href="modifypo.php?id=<?php echo $row["po_number"]; ?>" target="_blank">Modify  </a></td>
     <?php } ?>
          <td><a href="#">Print / </a><a href="#">Email / </a><a href="#">Whatsapp /</a></td>
      </tr>
      <?php
  }
  ?>
    </table>
  </div>

</body>
</html>
