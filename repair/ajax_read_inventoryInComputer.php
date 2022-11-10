<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Classroom;
?>

<?php

if(isset($_REQUEST['computerID'])) {
    $Obj = new classroom();
    $inventories = $Obj -> readConnectInventoryToComputer($_REQUEST['computerID']);
    echo '<option selected disabled>เลือก</option>';
    foreach($inventories as $inventory) {
        $selected = ($inventory['ID'] == isset($_REQUEST['inventoryID'])) ? "selected" : ""; // เมื่อ user ทำการแก้ไขรายการซ่อมจะส่ง $_REQUEST['inventoryID'] มาเปรียบเทียบ
        echo "
            <option value='{$inventory['INVENTORYID']}'>{$inventory['INVENTORY_NAME']}</option> 
        ";
    }
}

?>