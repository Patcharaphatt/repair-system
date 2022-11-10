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
            <h4 class="title-forms">ฟอร์มเพิ่มห้องเรียน</h4>
        </div>
        <!-- forms -->
        <div class="card-body ">
            <form action="../save.php" method="GET">      
                <!-- hidden input -->
                <input type="hidden" name="action" value="createRoom">
                <input type="hidden" name="build" value="<?php echo $_REQUEST['build']; ?>">
                <input type="hidden" name="floor" value="<?php echo $_REQUEST['floor']; ?>">

                <!-- forms Groups -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <!-- name build -->
                        <div class="form-group">
                            <label for="NumberOfRoom">ต้องการเพิ่มอีกกี่ห้อง</label>
                            <input type="number" name="NumberOfRoom" id="NumberOfRoom" class="form-control my-2" required>
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
