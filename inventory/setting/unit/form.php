<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Unit;

if (isset($_REQUEST['action']) == 'edit') {
    $unitObj = new unit;
    $unit = $unitObj->getUnitById($_REQUEST['Id']); 
}

?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

	<div class="container">
				<div class="card-forms">
                    <!-- title forms -->
					<div class="card-header text-white d-flex justify-content-between">
                        <h4 class="title-forms">ฟอร์ม<?php echo (isset($_REQUEST['action'])=='edit') ? "แก้ไขหน่วยอุปกรณ์" : "เพิ่มหน่วยอุปกรณ์";?></h4>
                    </div>

                    <!-- forms -->
					<div class="card-body ">
						<form action="save.php" method="GET">
                            
                            <!-- hidden input -->
                            <input type="hidden" name="action" value="<?php echo (isset($_REQUEST['action'])=='edit') ? "edit" : "add";?>">
                            <input type="hidden" name="Id" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $unit['Id'] : "";?>">

                            <!-- forms Groups -->
                            
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <!-- mobile input -->
                                    <div class="form-group">
                                        <label for="unit_Name">ชื่อ - ประเภท</label>
                                        <input type="text" name="unit_Name" id="unit_Name" class="form-control my-2" maxlength="255" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $unit['title'] : "";?>" required>
            
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