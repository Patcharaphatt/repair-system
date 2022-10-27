<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Brand;
$brandObj = new brand;
$brand = $_REQUEST;
unset($brand['action']);

if ($_REQUEST['action'] == 'delete') { // รายการลบในอนาคตอาจจะต้องมาแก้ไขเพิ่มเติม
    $result = $brandObj->deleteBrand($brand['Id']);

    if($result){
        $_SESSION['alert'] = 'ลบข้อมูลสำเร็จ'; 
    }else {
        $_SESSION['error'] = 'มีการใช้ข้อมูลรายการนี้อยู่ในรายการอุปกรณ์ กรุณาลบรายการอุปกรณ์ก่อนทำรายการ';
    }
    
}

else if ($_REQUEST['action'] == 'edit') {
    
    $result = $brandObj->updateBrand($brand);

    if($result){
        $_SESSION['alert'] = 'แก้ไขข้อมูลสำเร็จ';    
    }else {
        $_SESSION['error'] = 'มีข้อมูลค่าซ้ำกรุณาเพิ่มข้อมูลใหม่อีกครั้ง';
    }
}

else if ($_REQUEST['action'] == 'add') {

    unset($brand['Id']);
    $result = $brandObj->addBrand($brand);

    if($result){
        $_SESSION['alert'] = 'เพิ่มข้อมูลสำเร็จ';    
    }else {
        $_SESSION['error'] = 'มีข้อมูลค่าซ้ำกรุณาเพิ่มข้อมูลใหม่อีกครั้ง';
    }
}


header("location: index.php");

?>