<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Department;
$departmentObj = new department;

if ($_REQUEST['action'] == 'delete') {
    $department = $_REQUEST;
    unset($department['action']);
    $departmentObj->deleteDepartment($_REQUEST['Id']);
    $_SESSION['alert'] = 'ลบข้อมูลสำเร็จ';
}
else if ($_REQUEST['action'] == 'edit') {
    $department = $_REQUEST;
    unset($department['action']);
    $departmentObj->updateDepartment($department);
    $_SESSION['alert'] = 'แก้ไขข้อมูลสำเร็จ'; 
}
else if ($_REQUEST['action'] == 'add') {
    $department = $_REQUEST;
    unset($department['action']);
    unset($department['Id']);
    $departmentObj->addDepartment($department); 
    $_SESSION['alert'] = 'เพิ่มข้อมูลสำเร็จ';
}


header("location: index.php");

?>