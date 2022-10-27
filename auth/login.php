<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>

<?php
use App\Model\Login;

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
        case 'Classroom Owner':
            header('location: /repair-system/ClassroomOwner/index.php');
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