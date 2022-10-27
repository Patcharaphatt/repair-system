<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php


use App\Model\Account;
$accountObj = new account;

if ($_REQUEST['action'] == 'edit') {

    $user = $_REQUEST;
    unset($user['action']);
    $accountObj->updateAccount($user); 
}

$Id = $_REQUEST['Id'];
$_SESSION['alert'] = 'อัพเดทข้อมูลโปรไฟล์เสร็จเรียบร้อย';
header("location: form.php?action=edit&Id=$Id");

?>