<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Classroom;
$classroomObj = new classroom;
$classroom = $_REQUEST;
unset($classroom['action']);


switch ($_REQUEST['action']) {

    case 'delete':
        $inventoryObj->deleteInventory($inventory['inventory_Name']);
        $_SESSION['alert'] = "ลบรายการอุปกรณ์ '{$inventory['inventory_Name']}' สำเร็จ";

    case 'edit':
        $result = $inventoryObj->updateInventory($inventory);

        if ($result === 1) {
            $_SESSION['error'] = "ชื่ออุปกรณ์ '{$inventory['inventory_Name']}' ซ้ำในระบบกรุณาทำรายการใหม่อีกครั้ง";
        }
        else {
            $_SESSION['alert'] = "อัพเดทข้อมูลอุปกรณ์ '{$inventory['inventory_Name']}' สำเร็จ";  
        }

    case 'add-build':
        unset($classroom['get_classroom_ById']);
        $result = $classroomObj->addBuild($classroom);

        if($result === 1) {
            $_SESSION['error'] = "มีชื่ออาคารซ้ำในระบบ กรุณาลองเพิ่มใหม่อีกครั้ง";
        } else {
            $_SESSION['alert'] = "เพิ่มอาคารเรียนสำเร็จ";
        }
}

header("location: index.php");

?>