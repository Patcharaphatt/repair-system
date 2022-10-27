<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>

<?php

use App\Model\Role;
use App\Model\account;
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>หน้าจัดการผู้ใช้งาน</title>
	<!-- include link conect file custom css -->
    <?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/css/css_link/css.inc.link.php";?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="card">
            <label for="username"><h1>เข้าสู่ระบบ</h1></label>

            <?php
                session_start();
                if(isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger" role="alert">
                            อีเมล์ หรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง
                          </div>';
                    unset($_SESSION['error']);
                }
                
            ?>
  
            <form action="login.php" method="POST">
                <div class="input-group d-flex align-items-center">
                    <div class="container-icon d-flex justify-content-center align-items-center">
                        <i class="fa-solid fa-user"></i>
                    </div>  
                    <input type="email" name="email" id="email" placeholder="อีเมล์"> 
                </div>
                <div class="input-group d-flex align-items-center">
                    <div class="container-icon d-flex justify-content-center align-items-center">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <input type="password" name="password" id="password" placeholder="รหัสผ่าน">
                </div>
                <button type="submit" class="btn-ct btn btn-success">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>
		
	<!-- footer -->
	<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>


</body>
</html>