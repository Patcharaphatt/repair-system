<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>

<?php
use App\Model\Login;
use App\Model\OwnerClassDepart;

$user_obj = new login;
$result = $user_obj->login($_POST);

if($result){

    switch($_SESSION['role']) {
        
        case 'Admin':
            header('location: /repair-system/admin/index.php');
            break;
        case 'Technician':
            header('location: /repair-system/technician/index.php');
            break;
        case 'ClassroomOwner': // ทำการเปลื่ยนแปลงตรงนี้ แทรกฟอร์มไปด้วยถ้ายังไม่ได้ยืนยันอุปกรณ์
            
            if($_SESSION['status'] == 1){ // ให้ไปหน้าหลัก
                header('location: /repair-system/ClassroomOwner/index.php');
            }else if ($_SESSION['status'] == -1) // ให้ไปหน้ายืนยันอุปกรณ์
                $Obj = new ownerClassDepart;
                $roomObj = $Obj->readOwnerClassDeptByAccountId($_SESSION['Id']); // เอาข้อมูล db เจ้าของห้องมา โดยอ้างอิง Id account จากการ Login
                // print_r($roomObj);exit;
                header("location: /repair-system/classroom/inventory/details_Inventory_confirm.php?action=InventoriesConfirmByOwnerRoom&roomID={$roomObj['ROOMID']}");
            break;
        default:
            header('location: /repair-system/auth/index.php');  
    }

	
} else {
    session_start();
    $_SESSION['error'] = '';
	header('location: /repair-system/auth/index.php');
}
?>