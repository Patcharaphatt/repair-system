<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Category;
$categoryObj = new category;
$category = $_REQUEST;
unset($category['action']);

if ($_REQUEST['action'] == 'delete') { // รายการลบในอนาคตอาจจะต้องมาแก้ไขเพิ่มเติม
    $result = $categoryObj->deleteCategory($category['Id']);
    
    if($result){
        $_SESSION['alert'] = 'ลบข้อมูลสำเร็จ'; 
    }else {
        $_SESSION['error'] = 'มีการใช้ข้อมูลรายการนี้อยู่ในรายการอุปกรณ์ กรุณาลบรายการอุปกรณ์ก่อนทำรายการ';
    }
}

else if ($_REQUEST['action'] == 'edit') {
    $result = $categoryObj->updateCategory($category);

    if($result){
        $_SESSION['alert'] = 'แก้ไขข้อมูลสำเร็จ';    
    }else {
        $_SESSION['error'] = 'มีข้อมูลค่าซ้ำกรุณาเพิ่มข้อมูลใหม่อีกครั้ง';
    }
}

else if ($_REQUEST['action'] == 'add') {
    unset($category['Id']);
    $result = $categoryObj->addCategory($category);

    if($result){
        $_SESSION['alert'] = 'เพิ่มข้อมูลสำเร็จ';    
    }else {
        $_SESSION['error'] = 'มีข้อมูลค่าซ้ำกรุณาเพิ่มข้อมูลใหม่อีกครั้ง';
    }
    
}


header("location: index.php");

?>