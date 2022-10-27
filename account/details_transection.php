<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Account;
use App\Model\Department;
use App\Model\Role;

if (isset($_REQUEST['action']) == 'edit') {
    $accountObj = new account;
    $user = $accountObj->getAccountById($_REQUEST['Id']); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PDO Basic</title>

	<!-- include link conect file custom css -->
    <?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/css/css_link/css.inc.link.php";?>

    <!-- icon link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>

    <!-- navbar -->
    <?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

	<div class="container d-flex justify-content-center">
				<div class="card-forms card-forms-width ">
                    <!-- title forms -->
					<div class="card-header text-white d-flex justify-content-between">
                        <h4 class="title-forms">รายระเอียดเต็ม</h4>
                    </div>

                    <!-- forms -->
					<div class="card-body">
						<form action="save.php" method="GET">

                            <!-- full name -->
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col col-lg-6">
                                                <label for="fullname">ชื่อ-นามสกุล</label>
                                            </div>
                                            <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                                <p class="d-inline"><?php echo $user['fullname'];?></p>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                            </div>

                            <!-- email name -->
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col col-lg-6">
                                                <label for="email">อีเมล์</label>
                                            </div>
                                            <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                                <p class="d-inline"><?php echo $user['email'];?></p>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                            </div>

                            <!-- username name -->
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col col-lg-6">
                                                <label for="username">Username</label>
                                            </div>
                                            <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                                <p class="d-inline"><?php echo $user['username'];?></p>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                            </div>

                            <!-- mobile -->
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col col-lg-6">
                                                <label for="mobile">เบอร์โทรศัพท์</label>
                                            </div>
                                            <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                                <p class="d-inline"><?php echo $user['mobile'];?></p>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                            </div>

                            <!-- mobile -->
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col col-lg-6">
                                                <label for="mobile">สิทธิ์การใช้งาน</label>
                                            </div>

                                            <?php
                                                $rolesObj = new Role();
                                                $role = $rolesObj -> getAllRolesById($user['roleId']);
                                            ?>

                                            <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                                <p class="d-inline"><?php echo $role['roleTitle'];?></p>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                            </div>

                        </form>	
					</div>
				</div>
	</div>
    <!-- footer -->
    <?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>
</body>
</html>