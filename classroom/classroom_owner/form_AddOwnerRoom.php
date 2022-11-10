<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Account;
use App\Model\OwnerClassDepart;
?>

<?php
if (isset($_REQUEST['action']) == 'cancelOwnerRoom') {
    $Obj = new ownerClassDepart;
    $userID_SelectByRoomID = $Obj->readOwnerClassDeptByroomId($_REQUEST['roomID']); // ดึงข้อมูลผู้ดูแลห้อง
    // print_r($userID_SelectByRoomID);exit;
}
?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

<div class="container">
    <div class="card-forms">
        <!-- title forms -->
        <div class="card-header text-white d-flex justify-content-between">
            <h4 class="title-forms">ฟอร์ม<?php echo "จัดการผู้ดูแลห้อง {$_REQUEST['roomNUMBER']}";?></h4>
        </div>

        <!-- forms -->
        <div class="card-body ">
            <form action="../save.php" method="GET">
                
                <!-- hidden input -->
                <input type="hidden" name="action" value="<?php echo (isset($_REQUEST['action'])=='cancelOwnerRoom')
                ? "cancelOwnerRoom" : "addOwnerRoom";?>">
                <input type="hidden" name="roomID" value="<?php echo $_REQUEST['roomID']; ?>">
                <input type="hidden" name="roomNUMBER" value="<?php echo $_REQUEST['roomNUMBER']; ?>">
                <input type="hidden" name="build" value="<?php echo $_REQUEST['build']; ?>">
                <input type="hidden" name="floor" value="<?php echo $_REQUEST['floor']; ?>">

                <?php if(isset($_REQUEST['action']) == 'cancelOwnerRoom') { ?>
                    <input type="hidden" name="userByID" value="<?php echo $userID_SelectByRoomID['ACCOUNTID']; ?>">
                <?php } ?>

                <!-- forms Groups -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">      
                            <!-- users input -->
                            <label for="userByID">รายชื่อ-เจ้าของห้อง</label>
                            <select name="userByID" id="userByID" class="form-control my-2" required <?php echo (isset($_REQUEST['action'])=='cancelOwnerRoom')? "disabled " : "";?>>
                                <?php
                                    if($_REQUEST['action'] == 'cancelOwnerRoom'){
                                        $stus= -1;
                                    }else{
                                        $stus= -2;
                                    }
                                    $Obj = new account();
                                    $users = $Obj->readAllAccount(null, $stus);
                                    echo '<option disabled>เลือก</option>';
                                    foreach($users as $user) {
                                        $selected = ($user['ID'] == $userID_SelectByRoomID['ACCOUNTID']) ? "selected" : "";
                                        echo "
                                            <option value='{$user['ID']}' {$selected}>{$user['FULL_NAME']}</option> 
                                        ";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php if(isset($_REQUEST['action']) == 'cancelOwnerRoom'){ ?>
                    <button class="btn-ct btn btn-orange" id="heckFormsAccount" type="submit" 
                    onclick="return cancelOwnerRoom()">ยกเลิกผู้ดูแล</button>
                <?php }else{ ?>
                    <button class="btn-ct btn btn-success" id="heckFormsAccount" type="submit" 
                    onclick="return confirm_editAcc()">บันทึกข้อมูล</button>
                <?php } ?>
            </form>	
        </div>
    </div>
</div>

<!-- footer -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>