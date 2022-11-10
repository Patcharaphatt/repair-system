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

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

	<div class="container">
				<div class="card-forms">
                    <!-- title forms -->
					<div class="card-header text-white d-flex justify-content-between">
                        <h4 class="title-forms">ฟอร์ม<?php echo (isset($_REQUEST['action'])=='edit') ? "แก้ไขข้อมูลผู้ใช้งาน" : "เพิ่มผู้ใช้งานระบบ";?></h4>
                    </div>

                    <!-- forms -->
					<div class="card-body ">
						<form action="save.php" method="GET">
                            
                            <!-- hidden input -->
                            <input type="hidden" name="action" value="<?php echo (isset($_REQUEST['action'])=='edit') ? "edit" : "add";?>">
                            <input type="hidden" name="Id" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $user['Id'] : "";?>">

                            <!-- forms Groups -->
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <!-- fullname input -->
                                    <div class="form-group">
                                        <label for="fullname">ชื่อ-นามสกุล</label>
                                        <input type="text" name="fullname" id="fullname" class="form-control my-2" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $user['fullname'] : "";?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <!-- email input -->
                                        <label for="email">อีเมล์</label>
                                        <input type="email" name="email" id="email" class="form-control my-2" maxlength="255" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $user['email'] : "";?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <!-- username input -->
                                    <div class="form-group">
                                        <label for="username">username</label>
                                        <input type="text" name="username" id="username" class="form-control my-2" maxlength="255" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $user['username'] : "";?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <!-- password input -->
                                        <label for="password">password</label>
                                        <input type="<?php echo (isset($_REQUEST['action'])=='edit') ? "text" : "password";?>" name="password" id="password" class="form-control my-2" maxlength="255" value="" placeholder="<?php echo (isset($_REQUEST['action'])=='edit') ? "เปลื่ยนรหัสผ่านใหม่" : "";?>" <?php echo (isset($_REQUEST['action'])=='edit') ? "" : "required";?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <!-- mobile input -->
                                    <div class="form-group">
                                        <label for="mobile">เบอร์โทรศัพท์</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control my-2" maxlength="10" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $user['mobile'] : "";?>" required>
            
                                    </div>
                                </div>

                                <?php if(isset($_REQUEST['action'])!='edit') { ?>
                                <div class="col-lg-6">
                                    <div class="form-group">      
                                        <!-- role input -->
                                        <label for="roleId">สิทธิ์การใช้งาน</label>
                                        <select name="roleId" id="roleId" class="form-control my-2" required>
                                            <option value="">เลือก</option>
                                            <?php
                                                $rolesObj = new Role();
                                                $roles = $rolesObj -> getAllRoles();
                                                foreach($roles as $role) {
                                                    $selected = ($role['roleId'] == $user['roleId']) ? "selected" : "";
                                                    echo "
                                                        <option value='{$role['roleId']}' {$selected}>{$role['roleTitle']}</option> 
                                                    ";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                
                            </div>
                            <button class="btn-ct btn btn-success" id="heckFormsAccount" type="submit" 
                            onclick="return <?php echo (isset($_REQUEST['action'])=='edit') ? 'confirm_editAcc()':'confirm_createAcc()'; ?>">บันทึกข้อมูล</button>
                        </form>	
					</div>
				</div>
	</div>

    <!-- footer -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>