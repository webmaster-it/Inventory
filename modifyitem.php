<?php
include 'header.php';
include 'dbconnection.php';
$categories = [];
$subcategories = [];
$codess=$_GET['id'];
$cat_result = $conn->query("SELECT code, name FROM category_master WHERE status='Active'");
while ($row = $cat_result->fetch_assoc()) {
    $categories[$row['code']] = $row['name'];
}

$sub_result = $conn->query("SELECT code, name, category_code FROM subcategory_master WHERE status='Active'");
while ($row = $sub_result->fetch_assoc()) {
    $subcategories[] = $row;
}

$result = $conn->query("SELECT i.code AS `Item Code`,
  i.name AS `Item Name`,
  i.manufacturer_code AS `Mfg Code`,
  i.manufacturer AS `Manufact`,
  i.default_vendor AS `Vendor`,
  i.storage_temp AS `Storage Temp`,
  i.testname AS `Tests Names`,
  i.storage_location AS `Storage Loc`,
  m.name AS `Mfg Name`,
  l.name AS `Location`,
  i.purchase_unit AS `Per. Unit`,
  i.issue_unit AS `Iss. Unit`,
  i.conversion_factor AS `Conv. Factor`,
  i.pack_size AS `Pack Size`,
  i.default_rate AS `Rate`,
  v.name AS `Pimary Suppl.`,
  sc.name AS `Test Name`,
  t.name AS `Temp`,
  uni.name AS `Purcha Name`,
  i.subcategory_code AS `subcatgory code`,
   i.category_code AS `catgory code`,
   i.department_codes AS `department code`


FROM item_master i
LEFT JOIN manufacturer_master m ON i.manufacturer = m.code
LEFT JOIN location_master l ON i.storage_location = l.code
LEFT JOIN vendor_master v ON i.default_vendor = v.code
LEFT JOIN subcategory_master sc ON i.subcategory_code = sc.code
LEFT JOIN unit_master uni ON i.purchase_unit = uni.code
LEFT JOIN temperature_master t ON i.storage_temp = t.code WHERE i.code='$codess'");
$rowsssss = $result->fetch_assoc();
//print_r($rowsssss);

if(isset($_POST['submit']))
  {
    $name = $_POST['name'];
$category = $_POST['category'];
$subcategory = $_POST['subcategory'];
$department = $_POST['department'];
$purchase_unit = $_POST['purchase_unit'];
$issue_unit = $_POST['issue_unit'];
$conversion_factor = $_POST['conversion_factor'];
$pack_size = $_POST['pack_size'];
$manufacturer = $_POST['manufacturer'];
$manufacturer_code = $_POST['manufacturer_code'];
$default_vendor = $_POST['default_vendor'];
$default_rate = $_POST['default_rate'];
/*$secondary_vendors = $_POST['secondary_vendors'];*/
$reorder_level = $_POST['reorder_level'];
$opening_stock = $_POST['opening_stock'];
$min_order_qty = $_POST['min_order_qty'];
$storage_location = $_POST['storageLocation'];
$storage_temp = $_POST['storageTemp'];
$expiry_applicable = $_POST['expiryApplicable'];
$batch_tracking = $_POST['batchTracking'];
$min_expiry_days = $_POST['minExpiryField'];
$purchase_lead_time = $_POST['purchase_lead_time'];
$tax = $_POST['tax'];
$amcc = $_POST['amcc'];
$status = $_POST['status'];
$testname = $_POST['testname'];
$secondaryvend = $_POST['secondaryvend'];
$secondaryrate = $_POST['secondaryrate'];
$newArray2 = array();
foreach ($secondaryvend as $kvalue2) {
    $newArray2[] = $kvalue2;
}

$sampleiddsall = $newArray2;
$implode2=implode(',',$sampleiddsall);
$newArray3 = array();
foreach ($secondaryrate as $kvalue3) {
    $newArray3[] = $kvalue3;
}

$testssall3 = $newArray3;
$implode3=implode(',',$testssall3);
    $updateQuery = 'UPDATE `item_master` SET
  `name` = "'.$name.'",
  `category_code` = "'.$category.'",
  `subcategory_code` = "'.$subcategory.'",
  `department_codes` = "'.$department.'",
  `purchase_unit` = "'.$purchase_unit.'",
  `issue_unit` = "'.$issue_unit.'",
  `conversion_factor` = "'.$conversion_factor.'",
  `pack_size` = "'.$pack_size.'",
  `manufacturer` = "'.$manufacturer.'",
  `manufacturer_code` = "'.$manufacturer_code.'",
  `default_vendor` = "'.$default_vendor.'",
  `default_rate` = "'.$default_rate.'",
  `reorder_level` = "'.$reorder_level.'",
  `opening_stock` = "'.$opening_stock.'",
  `min_order_qty` = "'.$min_order_qty.'",
  `storage_location` = "'.$storage_location.'",
  `storage_temp` = "'.$storage_temp.'",
  `status` = "'.$status.'",
  `testname` = "'.$testname.'"
WHERE `code` = "'.$codess.'"';
$rowsnew = $conn->query($updateQuery);
 $displaystr = "Item Update Successfully !!";
  }
?>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; padding: 20px; }
        .container { background: #fff; padding: 30px; max-width: 1100px; margin: auto; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.05); margin-top: 50px; }
        h2 { text-align: center; margin-bottom: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 6px; }
        input[type="text"], input[type="number"], select, input[type="file"] {
            width: 100%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;
        }
        .form-row { display: flex; gap: 20px; }
        .form-row .form-group { flex: 1; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; background: #3498db; color: white; font-size: 16px; cursor: pointer; }
        .btn:hover { background: #2980b9; }
        #minExpiryField { display: none; }
    </style>
</head>
<body>
    <div class="container">
        <h4 class="card-title" style="color: green;"><?php if($displaystr != "") echo $displaystr;?></h4>
        <h2>Item Master Modification</h2>
       
<form method="post" action="" enctype="multipart/form-data">
        <div class="form-group"><label>Item Name</label><input name="name" type="text" value="<?php echo $rowsssss["Item Name"]; ?>"></div>
        <div class="form-group"><label>Item Photo</label><input type="file" name="paymentqr"></div>

        <div class="form-row">
            <div class="form-group"><label>Category</label><!-- Category Select -->
<select id="category" onchange="filterSubcategories()" name="category">
  <option value="">Select Category</option>
  <?php foreach ($categories as $code => $name): ?>
    <option value="<?=$code?>" <?php if ($code==$rowsssss["catgory code"]): echo  "selected=selected" ?>
                                                               
                                                             <?php endif ?>><?=$name?></option>
  <?php endforeach; ?>
</select>

<!-- Subcategory Select -->

</div>
            <div class="form-group"><label>Subcategory</label><select id="subcategory" name="subcategory">
  <option value="">Select Subcategory</option>
  <?php foreach ($subcategories as $sub): ?>
       <option value="<?=$sub['code']?>" <?php if ($sub['code']==$rowsssss["subcatgory code"]): echo  "selected=selected" ?>
                                                               
                                                             <?php endif ?>><?=$sub['name']?></option>
  <?php endforeach; ?>
   
</select></div>
        </div>

        <div class="form-group"><label>Department</label><select id="department" name="department">
            <option>Select Department</option>
        <?php
$cat_resultdepart = $conn->query("SELECT * FROM department_master WHERE status='Active'");
while ($rowdepr = $cat_resultdepart->fetch_assoc()) {
    
    ?>
    <option value="<?=$rowdepr['code']?>" <?php if ($rowdepr['code']==$rowsssss["department code"]): echo  "selected=selected" ?>
                                                               
                                                             <?php endif ?>><?=$rowdepr['name']?></option>
<option value="<?= $rowdepr['code'] ?>">
      <?= $rowdepr['name'] ?></option>
    <?php


}
        ?>
        </select></div>

        <div class="form-row">
            <div class="form-group"><label>Purchase Unit</label><select id="purchase_unit" name="purchase_unit"><?php
$cat_resultunit = $conn->query("SELECT * FROM unit_master WHERE status='Active'");
while ($rowdunit = $cat_resultunit->fetch_assoc()) {
    
    ?>
     <option value="<?=$rowdunit['code']?>" <?php if ($rowdunit['code']==$rowsssss["Per. Unit"]): echo  "selected=selected" ?>
                                                               
                                                             <?php endif ?>><?=$rowdunit['name']?></option>
    <?php


}
        ?></select></div>
            <div class="form-group"><label>Issue Unit</label><select id="issue_unit" name="issue_unit"><?php
$cat_resultunit = $conn->query("SELECT * FROM unit_master WHERE status='Active'");
while ($rowdunit = $cat_resultunit->fetch_assoc()) {
    
    ?>
     <option value="<?=$rowdunit['name']?>" <?php if ($rowdunit['name']==$rowsssss["Iss. Unit"]): echo  "selected=selected" ?>
                                                               
                                                             <?php endif ?>><?=$rowdunit['name']?></option>
    <?php


}
        ?></select></div>
        </div>

        <div class="form-row">
            <div class="form-group"><label>Conversion Factor</label><input type="number" id="conversion_factor" name="conversion_factor" value="<?php echo $rowsssss["Conv. Factor"]; ?>"></div>
            <div class="form-group"><label>Pack Size</label><input type="number" id="pack_size" name="pack_size" value="<?php echo $rowsssss["Pack Size"]; ?>"></div>
        </div>

        <div class="form-group"><label>Manufacturer</label><select id="manufacturer" name="manufacturer"><?php
$cat_resultman = $conn->query("SELECT * FROM manufacturer_master WHERE status='Active'");
while ($rowdman = $cat_resultman->fetch_assoc()) {
    
    ?>
<option value="<?= $rowdman['name'] ?>">
      <?= $rowdman['name'] ?></option>
    <?php


}
        ?></select></div>
        <div class="form-group"><label>Manufacturer Code</label><input type="text" id="manufacturer_code" name="manufacturer_code" value="<?php echo $rowsssss["Mfg Code"]; ?>"></div>
        <div class="form-group"><label>Default Vendor</label><select id="default_vendor" name="default_vendor">
<option>Select Vendor</option>
            <?php
$cat_resultven = $conn->query("SELECT * FROM vendor_master WHERE status='Active'");
while ($rowdven = $cat_resultven->fetch_assoc()) {
    
    ?>
    <option value="<?=$rowdven['name']?>" <?php if ($rowdven['name']==$rowsssss["Vendor"]): echo  "selected=selected" ?>
                                                               
                                                             <?php endif ?>><?=$rowdven['name']?></option>
    <?php


}
        ?></select></div>
        <div class="form-group"><label>Default Vendor Purchase Rate</label><input type="number" id="default_rate" name="default_rate" value="<?php echo $rowsssss["Rate"]; ?>"></div>
    <div class="form-group"><label>Secondary Vendors (Max 5)</label>
        <div style="background:#f7faff; padding:15px; border-radius:6px;">
            <div class="form-row"><select name="secondaryvend[]"><option>Select Vendor</option><?php
$cat_resultven = $conn->query("SELECT * FROM vendor_master WHERE status='Active'");
while ($rowdven = $cat_resultven->fetch_assoc()) {
    
    ?>
<option value="<?= $rowdven['name'] ?>">
      <?= $rowdven['name'] ?></option>
    <?php


}
        ?></select><input type="number" name="secondaryrate[]" placeholder="Rate" /></div><br/>
            <div class="form-row"><select name="secondaryvend[]"><option>Select Vendor</option><?php
$cat_resultven = $conn->query("SELECT * FROM vendor_master WHERE status='Active'");
while ($rowdven = $cat_resultven->fetch_assoc()) {
    
    ?>
<option value="<?= $rowdven['name'] ?>">
      <?= $rowdven['name'] ?></option>
    <?php


}
        ?></select><input type="number" name="secondaryrate[]" placeholder="Rate" /></div><br/>
            <div class="form-row"><select name="secondaryvend[]"><option>Select Vendor</option><?php
$cat_resultven = $conn->query("SELECT * FROM vendor_master WHERE status='Active'");
while ($rowdven = $cat_resultven->fetch_assoc()) {
    
    ?>
<option value="<?= $rowdven['name'] ?>">
      <?= $rowdven['name'] ?></option>
    <?php


}
        ?></select><input type="number" name="secondaryrate[]" placeholder="Rate" /></div><br/>
            <div class="form-row"><select name="secondaryvend[]"><option>Select Vendor</option><?php
$cat_resultven = $conn->query("SELECT * FROM vendor_master WHERE status='Active'");
while ($rowdven = $cat_resultven->fetch_assoc()) {
    
    ?>
<option value="<?= $rowdven['name'] ?>">
      <?= $rowdven['name'] ?></option>
    <?php


}
        ?></select><input type="number" name="secondaryrate[]" placeholder="Rate" /></div><br/>
            <div class="form-row"><select name="secondaryvend[]"><option>Select Vendor</option><?php
$cat_resultven = $conn->query("SELECT * FROM vendor_master WHERE status='Active'");
while ($rowdven = $cat_resultven->fetch_assoc()) {
    
    ?>
<option value="<?= $rowdven['name'] ?>">
      <?= $rowdven['name'] ?></option>
    <?php


}
        ?></select><input type="number" name="secondaryrate[]" placeholder="Rate" /></div>
        </div>
    </div>

        <div class="form-group"><label>Reorder Level</label><input type="number" id="reorder_level" name="reorder_level" value="<?php echo $rowsssss["reorder_level"]; ?>"></div>
        <div class="form-group"><label>Critical Stock Level</label><input type="number" id="opening_stock" name="opening_stock" value="<?php echo $rowsssss["min_order_qty"]; ?>"></div>
       <!--  <div class="form-group"><label>Opening Stock</label><input type="number" id="opening_stock"></div> -->
        <div class="form-group"><label>Minimum Order Quantity</label><input type="number" id="min_order_qty" name="min_order_qty" value="<?php echo $rowsssss["min_order_qty"]; ?>"></div>

        <div class="form-group"><label>Storage Location</label>
            <select onchange="autoFillTemperature()" id="storageLocation" name="storageLocation">
                <option value="">Select</option>
                <?php
$cat_resultloc = $conn->query("SELECT * FROM location_master WHERE status='Active'");
while ($rowdloc = $cat_resultloc->fetch_assoc()) {
    
    ?>
    <option value="<?=$rowdloc['temperature_code']?>" <?php if ($rowdloc['temperature_code']==$rowsssss["Storage Loc"]): echo  "selected=selected" ?>
                                                               
                                                             <?php endif ?>><?=$rowdloc['temperature_code']?></option>
<option value="<?= $rowdloc['temperature_code'] ?>">
      <?= $rowdloc['temperature_code'] ?></option>
    <?php


}
        ?>
                
            </select>
        </div>
        <div class="form-group"><label>Storage Temperature</label><input type="text" id="storageTemp" readonly  name="storageTemp" value="<?php echo $rowsssss["Storage Temp"]; ?>"></div>

        <div class="form-row">
            <div class="form-group"><label>Batch Tracking?</label>
                <select id="batchTracking" onchange="toggleExpiryField()" name="batchTracking">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </div>
            <div class="form-group"><label>Expiry Applicable</label><input type="text" id="expiryApplicable" name="expiryApplicable" value="<?php echo $rowsssss["expiry_applicable"]; ?>" readonly></div>
        </div>

        <div class="form-group" id="minExpiryField" name="minExpiryField" style="display:none;"><label>Minimum Expiry Days Required</label><input type="number" value="<?php echo $rowsssss["min_expiry_days"]; ?>"></div>

        <div class="form-group"><label>Tax %</label><input type="number" id="tax" name="tax" value="<?php echo $rowsssss["tax"]; ?>"></div>
        <div class="form-group"><label>Purchase Lead Time</label><input type="number" id="purchase_lead_time" name="purchase_lead_time" value="<?php echo $rowsssss["purchase_lead_time"]; ?>"></div>

        <div class="form-row">
            <div class="form-group"><label>AMC (Manual Entry)</label><input type="number" id="amcc" name="amcc" value="<?php echo $rowsssss["amcc"]; ?>"></div>
            <div class="form-group"><label>AMC (Auto Calculated)</label><input type="number" disabled value="<?php echo $rowsssss[""]; ?>"></div>
        </div>
<div class="form-row">
    <div class="form-group"><label>Test Name</label>
    <textarea class="form-group"  rows="2" placeholder="Test Name" name="testname" style="    width: 100%;
    height: 55px;" ><?php echo $rowsssss["testname"]; ?></textarea>
</div>
        <div class="form-group"><label>Item Status</label>
            <select id="status" name="status"><option>Active</option><option>Inactive</option></select>
        </div>
    </div>

        <button type="submit" class="btn" name="submit">Save</button>
    </form>
    </div>
<script>
function filterSubcategories() {
  const selectedCat = document.getElementById('category').value;
  const subSelect = document.getElementById('subcategory');

  Array.from(subSelect.options).forEach(opt => {
    if (!opt.value) return; // keep placeholder
    const match = opt.getAttribute('data-category') === selectedCat;
    opt.style.display = match ? 'block' : 'none';
  });

  subSelect.value = ""; // reset selection
}
</script>

    <script>
               function toggleExpiryField() {
            var tracking = document.getElementById("batchTracking").value;
            var expiryField = document.getElementById("expiryApplicable");
            expiryField.value = tracking === "Yes" ? "Yes" : "No";
    var minExpiryDiv = document.getElementById("minExpiryField");
    minExpiryDiv.style.display = tracking === "Yes" ? "block" : "none";
        }

        function autoFillTemperature() {
            const tempMap = {
                "Fridge": "2°C to 8°C",
                "Freezer": "-20°C",
                "Room": "15°C to 25°C"
            };
            const location = document.getElementById("storageLocation").value;
            document.getElementById("storageTemp").value = tempMap[location] || "";
        }
    </script>


</body>
</html>
