<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Account;
?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

	<div class="container">
        <div class="card-forms">
            <!-- title forms -->
            <div class="card-header text-white d-flex justify-content-between">
                <h4 class="title-forms">ฟอร์มส่งรายการซ่อมให้นายช่าง</h4>
            </div>

            <!-- forms -->
            <div class="card-body ">
                <form action="save.php" method="GET">
                    
                    <!-- hidden input -->
                    <input type="text" name="action" value="sent_technician">
                    <input type="text" name="Id" value="<?php echo $_REQUEST['Id']?>">

                    <!-- forms Groups -->
                    <div class="row mb-4">
                        <div class="col-lg">
                            <!-- รายชื่อช่างเทคนิค -->
                            <div class="form-group">
                                <label for="department_Name">รายชื่อช่าง</label>
                                
                                <select name="techId" id="techId" class="form-control my-2" required>
                                    
                                    <?php
                                        
                                        $Obj = new account();
                                        // ดึงรายชื่อนายช่างมาแสดงโชว์
                                        echo '<option selected disabled>เลือก</option>';
                                        $accounts = $Obj->readAccountLevel(2);

                                        foreach($accounts as $account) {
                                            echo "
                                                <option value='{$account['ID']}'>{$account['FULL_NAME']}</option> 
                                            ";
                                        }
                                    ?>
                                </select>

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
