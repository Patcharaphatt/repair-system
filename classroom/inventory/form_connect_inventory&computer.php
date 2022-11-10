<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Inventory;
?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

<div class="container">
    <div class="card-forms">
        <!-- title forms -->
        <div class="card-header text-white d-flex justify-content-between">
            <h4 class="title-forms">ฟอร์มเชื่อมต่ออุปกรณ์</h4>
        </div>
        <!-- forms -->
        <div class="card-body">
            <form action="../save.php" method="GET">         
                <!-- hidden input -->
                <input type="hidden" name="action" value="<?php echo "InventoryConnectToComputer"; // ส่งค่า Action ?>">
                <input type="hidden" name="computerID" value="<?php echo $_REQUEST['computerID']; // ส่งค่า ID คอมพิวเตอร์ ?>">
                <input type="hidden" name="computerCODE" value="<?php echo $_REQUEST['computerCODE']; // ส่งค่าหมายเลขรหัสคอมพิวเตอร์ เช่น 1100-001 ?>">
                

                <!-- forms Groups -->  
                <div class="row mb-4">              
                    <div class="col-lg">
                        <!-- รายการอุปกรณ์ทั้งหมด -->
                        <div class="form-group">
                            <label for="inventoryName">รายการอุปกรณ์</label>
                            <!-- โชว์ รายชื่ออุปกรณ์ ที่เว้น name ไว้ช่องว่าง เพราะไม่ได้ส่งค่าอะไรไป -->
                            <select name="" id="inventoryName" class="form-control my-2" required autocomplete="off">
                                <option selected disabled>เลือก</option>
                                <?php
                                    $Obj = new inventory();
                                    $inventories = $Obj -> readAllInventory();
                                    foreach($inventories as $inventory) {
                                        echo "
                                            <option value='{$inventory['INVENTORY_NAME']}'>{$inventory['INVENTORY_NAME']}</option> 
                                        ";
                                    }
                                ?>
                            </select>
                            
                        </div>
                    </div>                
                </div>
                <div class="row mb-4">              
                    <div class="col-lg">
                        <!-- รายการอุปกรณ์ทั้งหมด -->
                        <div class="form-group">
                            <label for="serial_Inventory">หมายเลขเครื่อง/เลขทะเบียน</label>
                            <!-- โชว์ serial number อุปกรณ์ และส่งค่า ID อุปกรณ์ไป -->
                            <select name="inventoryID" id="serial_Inventory" class="form-control my-2" required></select>
                        </div>
                    </div>                
                </div>
                <button class="btn-ct btn btn-success" id="heckFormsAccount" type="submit" 
                onclick="return confirm_createAcc();">เชื่อมต่อ</button>
            </form>	
        </div>
    </div>
</div>

<!-- footer -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>
