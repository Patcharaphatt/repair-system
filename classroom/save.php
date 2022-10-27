<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\inventory;
$inventoryObj = new inventory;
$inventory = $_REQUEST;
unset($inventory['action']);

if ($_REQUEST['action'] == 'delete') {
    $inventoryObj->deleteInventory($inventory['inventory_Name']);
    $_SESSION['alert'] = "ลบรายการอุปกรณ์ '{$inventory['inventory_Name']}' สำเร็จ";
}

else if ($_REQUEST['action'] == 'edit') {
    $result = $inventoryObj->updateInventory($inventory);

    if ($result === 1) {
        $_SESSION['error'] = "ชื่ออุปกรณ์ '{$inventory['inventory_Name']}' ซ้ำในระบบกรุณาทำรายการใหม่อีกครั้ง";
    }
    else {
        $_SESSION['alert'] = "อัพเดทข้อมูลอุปกรณ์ '{$inventory['inventory_Name']}' สำเร็จ";  
    }    
}

else if ($_REQUEST['action'] == 'add') {
    unset($inventory['Id']);
    $result = $inventoryObj->addInventory($inventory);

    if ($result == 1) {
        $_SESSION['error'] = 'เลข serial number ที่คุณกรอกซ้ำในระบบ กรุณาทำรายการใหม่อีกครั้ง';
    }
    else if ($result == 2) {
        $_SESSION['error'] = 'ชื่ออุปกรณ์ซ้ำในระบบกรุณาทำรายการใหม่อีกครั้ง';
    } else {
        $_SESSION['alert'] = "เพิ่มข้อมูลสำเร็จ '{$inventory['inventory_Name']}' จำนวน {$inventory['stock']} รายการ";  
    }    
}


header("location: index.php");

?>