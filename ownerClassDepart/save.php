<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

// print_r($_REQUEST);
// exit;

use App\Model\OwnerClassDepart;
use App\Model\account;


$OwnerClassDepartObj = new ownerClassDepart;
$accountObj = new account;
$ownerClassDepart = $_REQUEST;

if ($_REQUEST['action'] == 'delete') {
    
    unset($ownerClassDepart['action']);
    $result = $OwnerClassDepartObj->deleteOwnerClassDept($ownerClassDepart['Id']);
    if($result) {
        $accountObj->updateAccStus($ownerClassDepart['userId'], -3);
        $_SESSION['alert'] = 'ลบข้อมูลสำเร็จ';
    } else {
        $_SESSION['error'] = 'ต้องยกเลิกผู้ดูแลห้องก่อนจึงจะสามารถลบรายการนี้ได้';
    }
    
}

else if ($_REQUEST['action'] == 'edit') {

    unset($ownerClassDepart['action']);
    $OwnerClassDepartObj->updateOwnerClassDept($ownerClassDepart);
    $_SESSION['alert'] = 'แก้ไขข้อมูลสำเร็จ';
}

else if ($_REQUEST['action'] == 'add') {

    $accountObj->updateAccStus($ownerClassDepart['userById'], -2);
    unset($ownerClassDepart['action']);
    unset($ownerClassDepart['Id']);
    $OwnerClassDepartObj->addOwnerClassDept($ownerClassDepart);
    $_SESSION['alert'] = 'เชื่อมต่อผู้แจ้งซ่อมกับแผนกเสร็จเรียบร้อย';
    
}


header("location: index.php");

?>