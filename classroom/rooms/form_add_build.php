<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Classroom;
?>


<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

<div class="container">
	<div class="card-forms">
        <!-- title forms -->
        <div class="card-header text-white d-flex justify-content-between">
            <h4 class="title-forms">ฟอร์มเพิ่มอาคารเรียน</h4>
        </div>
        <!-- forms -->
        <div class="card-body ">
            <form action="../save.php" method="GET">    
                <!-- hidden input -->
                <input type="hidden" name="action" value="createBuild">
                <!-- forms Groups -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <!-- name build -->
                        <div class="form-group">
                            <label for="build">ชื่อ-อาคาร</label>
                            <input type="number" name="build" id="build" class="form-control my-2" value="" required>
                        </div>
                    </div>
                </div>
                <div class="row mb-4 d-flex justify-content-end align-items-end">
                    <div class="col-lg-6">
                        <!-- name floor -->
                        <div class="form-group">
                            <label for="floor">มีกี่ชั้น</label>
                            <input type="text" name="floor" id="floor" class="form-control my-2" value="" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <!-- room -->
                            <label for="room">แต่ละชั้นมีกี่ห้อง</label>
                            <input type="text" name="room" id="room" class="form-control my-2" value="" required>
                        </div>
                    </div>
                </div>
                <button class="btn-ct btn btn-success" id="heckFormsAccount" type="submit" 
                onclick="return confirm_createAcc()">บันทึกข้อมูล</button>
            </form>	
        </div>
	</div>
</div>
<!-- footer -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>