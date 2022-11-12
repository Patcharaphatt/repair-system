<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Repair;
?>

<?php

$Obj = new repair;

$ARR_REQUEST = $_REQUEST;
$ACTION = $_REQUEST['action']; // เก็บค่า action จาก url

// unset array
unset($ARR_REQUEST['action']);

// จัดการรูปภาพ
$ext = end(explode(".", $_FILES['upload']['name'])); // แยกนามสกุลไฟล์ออกจากชื่อ
$NEW_NAME = "/repair-system/repair/imgs/" .md5(uniqid()).".{$ext}"; // สร้างชื่อแบบสุ่ม และเอานำสกุลที่แยกมาใส่ไว้ตรงท้าย
$IMAGE = "/repair-system/repair/imgs/" .md5(uniqid()).".{$ext}"; // เก็บรูปภาพไว้บันทึกลง database
move_uploaded_file($_FILES['upload']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$NEW_NAME); // ย้ายไฟล์ไปที่ folder imgs


switch ($ACTION) {
    case 'add':
        $ARR_REQUEST['Image'] = $IMAGE;
        $result = $Obj->createListOfRepair($ARR_REQUEST);
        if($result) {
            $_SESSION['alert'] = "ส่งคำร้องแจ้งซ่อมสำเร็จ กรุณารอฝ่าย IT support ดำเนินการตรวจสอบรายการ";
            header("location: /repair-system/ClassroomOwner/index.php");
            exit;
        }
        break;
    case 'edit':
}

?>