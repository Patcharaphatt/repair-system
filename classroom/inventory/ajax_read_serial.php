<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Inventory;
?>


<?php

if(isset($_REQUEST['inventoryName'])) {
    $Obj = new inventory();
    $inventories = $Obj -> readInventorySerialByNameInventory($_REQUEST['inventoryName']);
    echo '<option selected disabled>เลือก</option>';
    foreach($inventories as $inventory) {
        echo "
            <option value='{$inventory['ID']}'>{$inventory['SERIAL']}</option> 
        ";
    }
}

?>