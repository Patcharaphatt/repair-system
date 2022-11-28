<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\OwnerClassDepart;
use App\Model\Classroom;
use App\Model\Repair;
?>


<?php 
$accountId = $_SESSION['Id'];
// echo $accountID ;
$Obj_ownerRoom = new ownerClassDepart;
$Obj_classroom = new classroom;
$Obj_repair = new repair;

$ownerRoom = $Obj_ownerRoom->readOwnerClassDeptByAccountId($accountId); // ดึงข้อมูลผู้ดูแลห้องมา
// print_r($ownerRoom);exit;
if(isset($_REQUEST['action']) == 'edit') {
    $repairList = $Obj_repair->readListOfRepairById($_REQUEST['Id']); // ดึงข้อมูลรายการซ๋อมมาแสดงผล
}

// print_r($repairList);exit;
?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

<div class="container">
    <div class="card-forms">
        <!-- title forms -->
        <div class="card-header text-white d-flex justify-content-between">
            <h4 class="title-forms">ฟอร์มแจ้งซ่อมคอมพิวเตอร์</h4>
        </div>

        <!-- forms -->
        <div class="card-body ">
            <form action="save.php" method="POST" enctype="multipart/form-data"> 
                <!-- hidden input -->
                <input type="hidden" name="action" value="<?php echo isset($_REQUEST['action']) ? "edit" : "add";?>">
                <input type="hidden" name="ownerRoomID" value="<?php echo $_SESSION['Id']; // รหัสผู้ดูแลห้อง ?>">

                <?php // แสดง Id รายการซ่อมเพื่ออ้างอิงไว้แก้ไข
                    if(isset($_REQUEST['action']) == 'edit') {
                        echo "<input type='hidden' name='Id' value='{$_REQUEST['Id']}'>";
                    }
                ?>

                <!-- forms Groups -->

                <!-- เลือกหมายเลขคอม -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">          
                            <label for="computerID">รหัสคอม <small class="form-text text-danger">*</small></label>
                            <select name="computerID" id="computerID" class="form-control my-2" required autocomplete="off"
                            <?php echo (isset($_REQUEST['action']) == 'edit') ? "disabled" : "";?>>
                                <option selected disabled>เลือก</option>
                                <?php
                                    $roomId = $ownerRoom['ROOMID']; // ดึงไอดีห้องที่ผู้ดูแลห้องดูแลอยู่มาใส่ตัวแปร roomId
                                    $Obj = new classroom;
                                    $computers = $Obj->readAllComputersByRoomId($roomId); // ดึงรายการคอมพิวเตอร์ทั้งหมดที่ผู้ดูแลห้องดูแล
                                    foreach($computers as $computer) {
                                        $selected = ($computer['ID'] == $repairList['COMPUTERID']) ? "selected" : ""; // เมื่อ user ทำการแก้ไขรายการซ่อมจะส่ง $_REQUEST['computerID'] มาเปรียบเทียบ
                                        echo "
                                            <option value='{$computer['ID']}' {$selected}>{$computer['CODE']}</option> 
                                        ";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>                
                </div>

                <!-- อุปกรณ์ภายในหมายเลขคอมที่เสีย เลือกหมายเลขก่อน ถึงจะสามารถเลือกอุปกรณ์ที่เสียได้ -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="computerID">อุปกรณ์ที่เสีย <small class="form-text text-danger">*</small></label>
                            <select name="inventoryID" id="inventoryID" class="form-control my-2" required
                            <?php echo (isset($_REQUEST['action']) == 'edit') ? "disabled" : "";?>></select>
                        </div>
                    </div>                
                </div>
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="department_Name">รายระเอียดแจ้งซ่อม / ปัญหา</label>
                            <textarea name="details" class="form-control my-2" id="exampleFormControlTextarea1" rows="7" maxlength="500" autocomplete="off"><?php echo (isset($_REQUEST['action']) == 'edit') ? $repairList['DETAILS'] : ""; ?></textarea>
                        </div>
                    </div>                
                </div>
                <div class="row mb-4">
                    <div class="col-lg">       
                        <input class="form-control" id="formFileSm" type="file" autocomplete="off" name="upload">                
                        <input class="form-control" id="formFileSm" type="hidden" name="Image" value="<?php echo (isset($_REQUEST['action']) == 'edit') ? $repairList['OWNERROOM_IMG'] : ""; ?>">          
                    </div>
                </div>

                <button class="btn-ct btn btn-success" id="heckFormsAccount" type="submit" 
                onclick="return confirm_createAcc();">บันทึกข้อมูล</button>
            </form>	
        </div>
    </div>
</div>
<!-- footer -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>
