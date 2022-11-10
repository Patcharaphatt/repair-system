<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\classroom;
use App\Model\OwnerClassDepart;
?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>
<div class="container d-flex justify-content-center">

    <!-- รายการอุปกรณ์ภายในห้อง -->
    <div class="card-forms card-forms-width">
        <?php
            $Obj_Acc = new ownerClassDepart;
            $account = $Obj_Acc->readOwnerClassDeptByroomId($_REQUEST['roomID']); // ใช้ class นี้เพื่อดึงข้อมูลจาก db ผู้ดูแลห้อง
            $Obj = new ownerClassDepart;
            $msg = $Obj->readOwnerClassDeptByAccountId($account['ACCOUNTID']);

            // ข้อความแจ้งเตือนถ้าผู้ดูแลห้องกด เลือกไม่ครบจะขึ้นข้อความนี้
            if($msg['INVENTORY_CONFIRM_ALERT'] == 1 && isset($_REQUEST['action'])=='InventoriesConfirmByOwnerRoom') {
                $message = 'รอตรวจสอบอุปกรณ์จากผู้ดูแลระบบ ทางเราจะรีบดำเนินการให้เร็วที่สุด';
                echo "<div class='alert alert-danger' role='alert'>
                        $message
                        </div>";
            }
            // print_r($msg);
        ?>
        <!-- title forms -->
        <div class="card-header text-white d-flex justify-content-between">
            <h4 class="title-forms">รายการอุปกรณ์</h4>
        </div>
        <!-- forms -->
        <div class="card-body">
            <form action="../save.php" method="GET">
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <input type="hidden" name="accountID" value="<?php echo $account['ACCOUNTID']; // รหัสผู้ดูแลห้อง ?>">
                                <input type="hidden" name="roomID" value="<?php echo $_REQUEST['roomID']; // ไอดีห้องเรียน ?>">
                                <input type="hidden" name="action" value="<?php echo (isset($_REQUEST['action'])=='InventoriesConfirmByOwnerRoom') ? "InventoriesConfirmByOwnerRoom" : "ConfirmInventories";?>">

                                <?php if(isset($_REQUEST['action'])<>'InventoriesConfirmByOwnerRoom') { ?>
                                    <input type="hidden" name="build" value="<?php echo $_REQUEST['build']; // เลขตึก ?>">
                                    <input type="hidden" name="floor" value="<?php echo $_REQUEST['floor']; // เลขชั้น ?>">
                                <?php } ?>

                                
                                <!-- นับจำนวนคอมพิวเตอร์ทั้งหมดในห้องเรียน -->
                                <div class="py-3 d-flex justify-content-between">
                                    <label for="inventory_check">จำนวนคอมพิวเตอร์</label>
                                    <?php 
                                        $Obj = new classroom;
                                        $NumberOfComputer_ARR = $Obj->readAllComputersByRoomId($_REQUEST['roomID'], false); // นับจำนวนคอมพิวเตอร์ภายในห้อง
                                        $NumberOfComputers = $NumberOfComputer_ARR[0]['COUNT_COMPUTERID']; // จำนวนคอมพิวเตอร์ในห้อง
                                    ?>
                                    <p><?php echo $NumberOfComputers;?> เครื่อง</p>
                                </div>

                                <?php
                                    $computers = $Obj->readAllComputersByRoomId($_REQUEST['roomID']); 
                                    $roomId_Connect;
                                    $n=0;
                                    foreach($computers as $computer) { // ลูปคอมพิวเตอร์ทั้งหมดโดยอ้างอิง Id ห้อง (กรองคอมพิวเตอร์มาแล้วเอาเฉพาะคอมพิวเตอร์ที่อยู่ในห้องที่เลือก)
                                        $Connect = $Obj->readConnectInventoryToComputer($computer['ID']); // ดึงข้อมูล tbl_connect ที่มี IdComputer อยู่เพื่อกรองอุปกรณ์ที่เชื่อมต่อ
                                        if($Connect){ // ถ้ามีข้อมูลให้ดึงให้เข้า if นี้
                                            $Connect_inventories[$n] = $Connect; // เก็บค่าที่ลูปออกมา
                                            $n++;
                                            continue; // ให้โปรแกรมทำงานลูปต่อ 
                                        }
                                    }
                                    // echo $n;exit;
                                    // print_r($Connect_inventories);exit;
                                    $CountARR = count($Connect_inventories); // นับจำนวน Array
                                    // ลูปเอาชื่อใน Array มาเก็บในตัวแปร inventoryARR เพื่อที่จะเอาชื่ออุปกรณ์มา
                                    $n=0;
                                    for($index=0; $index<$CountARR; $index++) {
                                        
                                        foreach($Connect_inventories[$index] as $inventory) {
                                            $inventoryARR[$n] = $inventory['INVENTORY_NAME']; // ในตัวแปรนี้จะมีชื่ออุปกรณ์ที่ซ้ำกันอยู่ด้วย
                                            $n++;
                                        }
                                    }
                                    // echo $n;exit;
                                    // print_r($inventoryARR);exit;
                                    $inventory_Unique_ARR = array_unique($inventoryARR); // เอาชื่ออุปกรณ์ที่ซ้ำออกให้เหลือแต่ตัวที่ไม่ซ้ำ                
                                    $inventory_ARR_Count_Values = array_count_values($inventoryARR); // นับค่าซ้ำใน Array               
                                ?>

                                <!-- Loop อุปกรณ์ทั้งหมดในห้องมาแสดง -->
                                <?php foreach($inventory_Unique_ARR as $inventory) { ?>
                                <div class="py-3 d-flex justify-content-between">  
                                    <label for="inventory_check"><?php echo $inventory;?></label>
                                    <p><?php echo $inventory_ARR_Count_Values[$inventory];?></p>
                                </div>
                                <?php } ?>
                                
                                <?php if($msg['INVENTORY_CONFIRM_ALERT'] <> 1 && isset($_REQUEST['action']) == 'InventoriesConfirmByOwnerRoom') { ?>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <!-- unit -->
                                            <select name="checkList" id="checkList" class="form-control my-2" required>
                                                <option selected disabled>เลือก</option>
                                                <option value="completeList">รายการครบ</option>
                                                <option value="IncompleteList" class="text-danger">รายการไม่ครบ</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>   
                    </div>
                </div>
                
                    <button class="btn-ct btn btn-success mb-2" id="heckFormsAccount" type="submit" 
                    onclick="return confirm_createAcc();"
                    <?php echo (isset($_REQUEST['action'])=='InventoriesConfirmByOwnerRoom' && $msg['INVENTORY_CONFIRM_ALERT'] == 1) ? "disabled" : ""; ?>>ส่งตรวจสอบ</button>
                    
                <?php if(isset($_REQUEST['action'])=='InventoriesConfirmByOwnerRoom') { ?>
                    <small id="emailHelp" class="form-text text-danger">ตรวจสอบเช็คอุปกรณ์ภายในห้องที่ท่านดูแลให้ครบถ้วน ก่อนส่งรายการ</small>
                <?php } ?>
            </form>	
        </div>
    </div>
</div>
<!-- footer -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>