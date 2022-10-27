<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Account;
$accountObj = new account;

if ($_REQUEST['action'] == 'delete') {
    $accountObj->deleteAccount($_REQUEST['Id']);
    $_SESSION['alert'] = 'ลบข้อมูลสำเร็จ';
}
else if ($_REQUEST['action'] == 'edit') {
    $user = $_REQUEST;
    unset($user['action']);
    $accountObj->updateAccount($user);
    $_SESSION['alert'] = 'แก้ไขข้อมูลสำเร็จ';
}
else if ($_REQUEST['action'] == 'add') {
    $user = $_REQUEST;
    unset($user['action']);
    unset($user['Id']);
    $accountObj->addAccount($user); 
    $_SESSION['alert'] = 'เพิ่มข้อมูลสำเร็จ';
}


header("location: index.php");

?>