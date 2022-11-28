<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Repair;
use App\Model\Inventory;
?>

<?php

$Obj = new repair;
$Obj_inventory = new inventory;

$ARR_REQUEST = $_REQUEST;
$ACTION = $_REQUEST['action']; // เก็บค่า action จาก url

// unset array
unset($ARR_REQUEST['action']);

if(isset($_FILES['upload']['tmp_name'])) { // ตรวจสอบว่ามีการอัพโหลดรูปภาพมามั้ย
    // จัดการรูปภาพ
    $ext = end(explode(".", $_FILES['upload']['name'])); // แยกนามสกุลไฟล์ออกจากชื่อ
    $NEW_NAME = "/repair-system/repair/imgs/" .md5(uniqid()).".{$ext}"; // สร้างชื่อแบบสุ่ม และเอานำสกุลที่แยกมาใส่ไว้ตรงท้าย
    $IMAGE = $NEW_NAME; // เก็บรูปภาพไว้บันทึกลง database
    move_uploaded_file($_FILES['upload']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$NEW_NAME); // ย้ายไฟล์ไปที่ folder imgs
}


switch ($ACTION) {
    case 'add': // เพิ่มรายการแจ้งซ่อม
        // print_r($ARR_REQUEST);exit;
        $ARR_REQUEST['Image'] = $IMAGE;
        $Obj_inventory->updateInventoryRPStus($ARR_REQUEST['inventoryID'], 1); // เปลื่ยนสถานะอุปกรณ์เป็น 1 เพื่อบ่งบอกว่ากำลังดำเนินการซ่อมอยู่
        $result = $Obj->createListOfRepair($ARR_REQUEST);
        if($result) {
            $_SESSION['alert'] = "ส่งคำร้องแจ้งซ่อมสำเร็จ กรุณารอฝ่าย IT support ดำเนินการตรวจสอบรายการ";
            header("location: /repair-system/ClassroomOwner/index.php");
            exit;
        }
        break;
    case 'edit': // แก้ไขรายการแจ้งซ่อม
        unset($ARR_REQUEST['ownerRoomID']);
        if(isset($_FILES['upload']['tmp_name'])) { // เช็คว่ามีการอัพโหลดรุปภาพมามั้ย
            if($ARR_REQUEST['Image']) { // ลบรูปภาพเก่า
                unlink($_SERVER['DOCUMENT_ROOT'].$ARR_REQUEST['Image']);
            }
            $ARR_REQUEST['Image'] = $IMAGE;
        }
        // print_r($ARR_REQUEST);exit;
        $result = $Obj->editListOfRepairById($ARR_REQUEST);
        if($result) {
            $_SESSION['alert'] = "แก้ไขรายการซ่อมสำเร็จ";
            header("location: /repair-system/ClassroomOwner/index.php");
            exit;
        }
        break;
    case 'cancel': // ยกเลิกรายการแจ้งซ่อม
        // print_r($ARR_REQUEST);exit;
        $Obj_inventory->updateInventoryRPStus($ARR_REQUEST['inventoryId'], 0); // เปลื่ยนสถานะอุปกรณ์เป็น 0 ให้โชว์ข้อมูล
        unset($ARR_REQUEST['inventoryId']);
        $result = $Obj->updateStusListOfRepairById($ARR_REQUEST['Id'], 4); // เปลื่ยนสถานะรายการแจ้งซ่อม
        if($result) {
            $_SESSION['alert'] = "ยกเลิกรายการสำเร็จ";
            header("location: /repair-system/ClassroomOwner/index.php");
            exit;
        }
        break;
    case 'sent_technician': // ส่งรายการแจ้งซ่อมให้กับนายช่างเทคนิค
        $ARR_REQUEST['adminId'] = $_SESSION['Id']; // ไอดีแอดมินส่งรายการให้กับนายช่าง เพื่อใช้บันทึกเลยส่งค่าไปด้วย
        $ARR_REQUEST['admin_operates_date'] = date("Y-m-d H:i:s"); // วันเวลาส่งรายการซ๋อมให้กับช่างด้วยแอดมิน
        // print_r($ARR_REQUEST);exit;
        $Obj->sentListOfRepairToTechnician($ARR_REQUEST); // อัพเดทข้อมูลรายการแจ้งซ่อม
        $result = $Obj->updateStusListOfRepairById($ARR_REQUEST['Id'], 2); // เปลื่ยนสถานะรายการแจ้งซ่อม
        if($result) {
            $_SESSION['alert'] = "ส่งรายการให้นายช่างสำเร็จ";
            header("location: /repair-system/admin/index.php");
            exit;
        }
        break;
}

?>