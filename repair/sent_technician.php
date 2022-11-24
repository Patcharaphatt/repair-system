<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Department;


if (isset($_REQUEST['action']) == 'edit') {
    $departmentObj = new department;
    $department = $departmentObj->getDepartmentById($_REQUEST['Id']); 
}

?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

	<div class="container">
				<div class="card-forms">
                    <!-- title forms -->
					<div class="card-header text-white d-flex justify-content-between">
                        <h4 class="title-forms">ฟอร์มส่งเรื่องให้ช่าง</h4>
                    </div>

                    <!-- forms -->
					<div class="card-body ">
						<form action="save.php" method="GET">
                            
                            <!-- hidden input -->
                            <input type="hidden" name="action" value="<?php echo (isset($_REQUEST['action'])=='edit') ? "edit" : "add";?>">
                            <input type="hidden" name="Id" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $department['Id'] : "";?>">

                            <!-- forms Groups -->
                            
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <!-- mobile input -->
                                    <div class="form-group">
                                        <label for="department_Name">รายชื่อช่าง</label>
                                        <input type="text" name="department_Name" id="department_Name" class="form-control my-2" maxlength="255" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $department['title'] : "";?>" required>
            
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
