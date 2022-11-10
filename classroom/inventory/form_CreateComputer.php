<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Account;
use App\Model\Department;
use App\Model\Role;
?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

<div class="container">
	<div class="card-forms">
        <!-- title forms -->
		<div class="card-header text-white d-flex justify-content-between">
            <h4 class="title-forms">ฟอร์มเพิ่มเครื่องคอมพิวเตอร์</h4>
        </div>

        <!-- forms -->
		<div class="card-body ">
			<form action="../save.php" method="GET">
                <!-- hidden input -->
                <input type="hidden" name="action" value="create-computer">
                <input type="hidden" name="roomNUMBER" value="<?php echo $_REQUEST['roomNUMBER']; ?>">
                <input type="hidden" name="roomID" value="<?php echo $_REQUEST['roomID']; ?>">
                <input type="hidden" name="build" value="<?php echo $_REQUEST['build']; ?>">
                <input type="hidden" name="floor" value="<?php echo $_REQUEST['floor']; ?>">

                <!-- forms Groups -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <!-- number of computer input -->
                        <div class="form-group">
                            <label for="numberOfComputer">จำนวนคอมพิวเตอร์</label>
                            <input type="number" name="numberOfComputer" id="numberOfComputer" class="form-control my-2" required autocomplete="off">
                        </div>
                    </div>
                </div>   
                <button class="btn-ct btn btn-success" id="heckFormsAccount" type="submit" 
                    onclick="return <?php echo (isset($_REQUEST['action'])=='edit') ? 'confirm_editAcc()':'confirm_createAcc()'; ?>">บันทึกข้อมูล
                </button>
            </form>	
		</div>
	</div>
</div>

<!-- footer -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>