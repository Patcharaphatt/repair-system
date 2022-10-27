<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Account;
use App\Model\Department;
use App\Model\OwnerClassDepart;


if (isset($_REQUEST['action']) == 'edit') {

    $OwnerClassDeptObj = new OwnerClassDepart;
    $OwnerClassDeptById = $OwnerClassDeptObj->getOwnerClassDeptById($_REQUEST['Id']);
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

	<div class="container">
				<div class="card-forms">
                    <!-- title forms -->
					<div class="card-header text-white d-flex justify-content-between">
                        <h4 class="title-forms">ฟอร์ม<?php echo (isset($_REQUEST['action'])=='edit') ? "แก้ไขข้อมูลแผนก" : "เพิ่มแผนกให้กับผู้แจ้งซ่อม";?></h4>
                    </div>

                    <!-- forms -->
					<div class="card-body ">
						<form action="save.php" method="GET">
                            
                            <!-- hidden input -->
                            <input type="hidden" name="action" value="<?php echo (isset($_REQUEST['action'])=='edit') ? "edit" : "add";?>">
                            <input type="hidden" name="Id" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $OwnerClassDeptById['Id'] : "";?>">

                            <!-- forms Groups -->
                            
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <!-- names's owner -->
                                    <div class="form-group">
                                        <label for="userById">ชื่อ-เจ้าของห้อง</label>   
                                        <select name="userById" id="userById" class="form-control my-2" required <?php echo (isset($_REQUEST['action'])=='edit') ? 'disabled' : "";?>>
                                            
                                            <?php
                                                
                                                $usersObj = new account();

                                                if(isset($_REQUEST['action']) == 'edit') {
                                                    $user = $usersObj->getAccountById($OwnerClassDeptById['account_Id']);
                                                    echo "
                                                        <option value='{$user['Id']}'>{$user['fullname']}</option> 
                                                    ";

                                                } else {

                                                    echo '<option value="">เลือก</option>';
                                                    $users = $usersObj->getAllAccount(null, -3);

                                                    foreach($users as $user) {
                                                        $selected = ($user['Id'] == $OwnerClassDeptById['account_Id']) ? "selected" : "";
                                                        echo "
                                                            <option value='{$user['Id']}' {$selected}>{$user['fullname']}</option> 
                                                        ";
                                                    }
                                                }
                                                
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>                
                                <div class="col-lg">
                                    <!-- แสดงแผนกทั้งหมด -->
                                    <div class="form-group">
                                        <label for="departById">แผนก</label>
                                        <select name="departById" id="departById" class="form-control my-2" required>
                                            <option value="">เลือก</option>
                                            <?php
                                                $departmentObj = new department();
                                                $departments = $departmentObj -> getAllDepartments();
                                                foreach($departments as $department) {
                                                    $selected = ($department['Id'] == $OwnerClassDeptById['department_Id']) ? "selected" : "";
                                                    echo "
                                                        <option value='{$department['Id']}' {$selected}>{$department['departTitle']}</option> 
                                                    ";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>                
                            </div>

                            <button class="btn-ct btn btn-success" id="heckFormsAccount" type="submit" 
                            onclick="return <?php echo (isset($_REQUEST['action'])=='edit') ? 'confirm_editAcc()':'confirm_createAcc()'; ?>">บันทึกข้อมูล</button>
                        </form>	
					</div>
				</div>
	</div>
    <!-- footer -->
    <?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>

    <script>
        function confirm_createAcc() {
            return confirm('ระบบจะเพิ่มผู้ใช้งานเข้าแผนกนี้');
        }

        function confirm_editAcc() {
            return confirm('ยืนยันการเปลื่ยนแปลงข้อมูล');
        }
    </script>
</body>
</html>