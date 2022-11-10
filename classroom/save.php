<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Classroom;
use App\Model\Account;
use App\Model\OwnerClassDepart;
use App\Model\Inventory;

// object
$classroomObj = new classroom;
$accountObj = new account;
$ownerClassDepartObj = new ownerClassDepart;
$inventoryObj = new inventory;


// get value from request
// print_r($_REQUEST);exit;
$ARR_REQUEST = $_REQUEST;
$ACTION = $_REQUEST['action']; // เก็บค่า action จาก url



// unset array
unset($ARR_REQUEST['action']);
unset($ARR_REQUEST['build_Name']);


switch ($ACTION) {

    case 'createBuild': // เพิ่มตึก
        unset($ARR_REQUEST['get_classroom_ById']);
        $result = $classroomObj->createBuild($ARR_REQUEST);

        if($result === 1) {
            $_SESSION['error'] = "มีชื่ออาคารซ้ำในระบบ กรุณาลองเพิ่มใหม่อีกครั้ง";
        } else {
            $_SESSION['alert'] = "เพิ่มอาคารเรียนสำเร็จ";
        }
        break;

    case 'addOwnerRoom': // เพิ่มผู้ดูแลห้อง
        // print_r($ARR_REQUEST);exit;
        $userByID = $ARR_REQUEST['userByID'];
        $roomID = $ARR_REQUEST['roomID'];
        $roomNUMBER = $ARR_REQUEST['roomNUMBER'];
        $build = $ARR_REQUEST['build'];
        $floor = $ARR_REQUEST['floor'];
        $UpdateStusOwnerClassroom_ARR = [$roomID, $userByID];
        $accountObj->updateAccStus($userByID, -1); // อัพเดทสถานะ account เป็น -1
        $ownerClassDepartObj->upDateRoom($roomID, $userByID); // อัพเดทว่าเจ้าของห้องคนนี้มีห้องเรียบร้อยแล้ว
        $result = $classroomObj->UpdateStusOwnerClassroom($roomID, 1); // อัพเดทสถานะของห้องว่ามีผู้ดูแลแล้ว
        if($result) {
            $_SESSION['alert'] = "เพิ่มผู้ดูแล ห้อง {$ARR_REQUEST['roomNUMBER']} เข้าระบบสำเร็จ สามารถไปตรวจสอบรายการอุปกรณ์ได้";
        }
        header("location: rooms/show_rooms.php?build={$build}&floor={$floor}");
        exit;
        break;
    
    case 'deleteRoom': // ลบรายการห้อง
        // print_r($ARR_REQUEST);exit;
        $roomID = $ARR_REQUEST['roomID'];
        $roomNUMBER = $ARR_REQUEST['roomNUMBER'];
        $build = $ARR_REQUEST['build'];
        $floor = $ARR_REQUEST['floor'];
        $result = $classroomObj->deleteRoom($roomID); // ลบรายการห้องเรียน
        if($result === false) {
            $_SESSION['error'] = "ต้องลบรายการคอมพิวเตอร์ให้หมดก่อน ถึงจะสามารถลบห้องหมายเลข {$roomNUMBER} ได้";
        }
        else{  
            $_SESSION['alert'] = "ลบห้องหมายเลข {$roomNUMBER} สำเร็จ";
        }
        header("location: rooms/show_rooms.php?build={$build}&floor={$floor}");
        exit;
        break;

    case 'createRoom': // เพิ่มห้องเรียน
        // print_r($ARR_REQUEST);exit;
        $build = $ARR_REQUEST['build'];
        $floor = $ARR_REQUEST['floor'];
        $result = $classroomObj->createRoom($ARR_REQUEST); // เพิ่มรายการห้องเรียน
        if($result) {
            $_SESSION['alert'] = "เพิ่มห้องเรียนสำเร็จ";
        }
        header("location: rooms/show_rooms.php?build={$build}&floor={$floor}");
        exit;
        break;
    case 'cancelOwnerRoom': //  ยกเลิกผู้ดูแลห้อง
        // print_r($ARR_REQUEST);exit;
        $userByID = $ARR_REQUEST['userByID'];
        $roomID = $ARR_REQUEST['roomID'];
        $roomNUMBER = $ARR_REQUEST['roomNUMBER'];
        $build = $ARR_REQUEST['build'];
        $floor = $ARR_REQUEST['floor'];
        $UpdateStusOwnerClassroom_ARR = [$roomID, $userByID];
        $accountObj->updateAccStus($userByID, -2); // อัพเดทสถานะ account เป็น -2
        $ownerClassDepartObj->upDateRoom(0, $userByID); // อัพเดทไม่มีผู้ดูแลห้อง
        $ownerClassDepartObj->updateStatusConfirmInventories($userByID, 0); // ไม่มีการแจ้งเตือน
        $classroomObj->updateStusComputerByRoomId($roomID, -2); // สถานะคอมพิวเตอร์จะเป็น -2
        $result = $classroomObj->UpdateStusOwnerClassroom($roomID, 0); // อัพเดทสถานะของห้องว่าไม่มีผู้ดูแล
        if($result) {
            $_SESSION['alert'] = "ยกเลิกผู้ดูแล ห้อง {$ARR_REQUEST['roomNUMBER']} สำเร็จ";
        }
        header("location: rooms/show_rooms.php?build={$build}&floor={$floor}");
        exit;
        break;

    case 'create-computer': // เพิ่มคอมพิวเตอร์เข้าห้อง
        // print_r($ARR_REQUEST);exit;
        $build = $ARR_REQUEST['build'];
        $floor = $ARR_REQUEST['floor'];
        $result = $classroomObj->createComputer($ARR_REQUEST);
        if($result) {
            $_SESSION['alert'] = "เพิ่มคอมพิวเตอร์จำนวน {$_REQUEST['numberOfComputer']} เครื่องสำเร็จ";
        }
        else{
            $_SESSION['error'] = "เพิ่มคอมพิวเตอร์ไม่สำเร็จ กรุณาติดต่อฝ่าย IT Support ทางเราจะแก้ไขปัญหาให้เร็วที่สุดขอบคุณครับ";
        }
        header("location: /repair-system/classroom/inventory/index.php?roomID={$ARR_REQUEST['roomID']}&roomNUMBER={$ARR_REQUEST['roomNUMBER']}&build={$build}&floor={$floor}");
        exit;
        break;
    
    case 'deleteComputer': // ลบคอมพิวเตอร์
        // print_r($ARR_REQUEST);exit;
        $computerCODE = $ARR_REQUEST['computerCODE'];
        $roomID = $ARR_REQUEST['roomID'];
        $roomNUMBER = $ARR_REQUEST['roomNUMBER'];
        $build = $ARR_REQUEST['build'];
        $floor = $ARR_REQUEST['floor'];
        // unset array เพื่อให้สามารถรัน SQL ได้
        unset($ARR_REQUEST['computerCODE']);
        unset($ARR_REQUEST['roomID']);
        unset($ARR_REQUEST['roomNUMBER']);
        $result = $classroomObj->deleteComputer($ARR_REQUEST['computerID']);
        if ($result === false) {
            $_SESSION['error'] = "ยังไม่ได้ยกเลิกการเชื่อมต่ออุปกรณ์ทั้งหมด กรุณายกเลิกการเชื่อมต่อทั้งหมดก่อน แล้วทำรายการใหม่อีกครั้ง";
        }else{
            $_SESSION['alert'] = "ลบคอมพิวเตอร์หมายเลข {$computerCODE} สำเร็จ";
        }
        header("location: /repair-system/classroom/inventory/index.php?roomID={$roomID}&roomNUMBER={$roomNUMBER}&build={$build}&floor={$floor}");
        exit;
        break;
        
    case 'InventoryConnectToComputer': // ทำการเชื่อมต่อคอมพิวเตอร์กับอุปกรณ์ ความสัมพันธ์แบบ 1:n
        $computerCODE = $ARR_REQUEST['computerCODE'];
        $inventoryOBJ = $inventoryObj->readInventoryById($ARR_REQUEST['inventoryID']); // ใช้ Object inventory
        // unset array เพื่อให้สามารถรัน SQL ได้
        unset($ARR_REQUEST['computerCODE']);
        $result = $classroomObj->connectInventoryToComputer($ARR_REQUEST); // บันทึกข้อมูลลงฐานข้อมูล conect_inventory_computer
        $inventoryObj->updateInventoryStus($ARR_REQUEST['inventoryID'], 1); // เปลื่ยนสถานะอุปกรณ์จาก 0 ให้เป็น 1 (0=อุปกรณ์ยังไม่ได้เชื่อมต่อ, 1=อุปกรณืเชื่อมต่อเรียบร้อยแล้ว)
        if($result) {
            $_SESSION['alert'] = "เชื่อมต่ออุปกรณ์ {$inventoryOBJ['INVENTORY_NAME']} รหัส {$inventoryOBJ['SERIAL']} กับคอมพิวเตอร์หมายเลข {$computerCODE} สำเร็จ";
        }else{
            $_SESSION['error'] = "ไม่สามารถเชื่อมต่อคอมกับอุปกรณ์ได้สำเร็จ กรุณาติดต่อฝ่าย IT Support ทางเราจะแก้ไขปัญหาให้เร็วที่สุดขอบคุณครับ";
        }
        header("location: inventory/show_Inventory.php?computerID={$ARR_REQUEST['computerID']}&computerCODE=$computerCODE");
        exit;
        break;

    case 'cancelConnect': // ยกเลิกการเชื่อมต่ออุปกรณ์กับคอมพิวเตอร์
        // print_r($ARR_REQUEST);exit;
        $computerCODE = $ARR_REQUEST['computerCODE'];
        $computerID = $ARR_REQUEST['computerID'];
        $inventoryID = $ARR_REQUEST['inventoryID'];
        $inventoryOBJ = $inventoryObj->readInventoryById($ARR_REQUEST['inventoryID']); // ใช้ Object inventory
        // unset array เพื่อให้สามารถรัน SQL ได้
        unset($ARR_REQUEST['computerID']);
        unset($ARR_REQUEST['computerCODE']);
        unset($ARR_REQUEST['inventoryID']);
        // print_r($ARR_REQUEST);exit;
        $result = $classroomObj->cancelConnectInventoryToComputer($ARR_REQUEST); // บันทึกข้อมูลลงฐานข้อมูล conect_inventory_computer
        $inventoryObj->updateInventoryStus($inventoryID, 0); // เปลื่ยนสถานะอุปกรณ์จาก 1 ให้เป็น 0 (0=อุปกรณ์ยังไม่ได้เชื่อมต่อ, 1=อุปกรณืเชื่อมต่อเรียบร้อยแล้ว)
        if($result) {
            $_SESSION['alert'] = "ยกเลิกการเชื่อมต่ออุปกรณ์ {$inventoryOBJ['INVENTORY_NAME']} รหัส {$inventoryOBJ['SERIAL']} กับคอมพิวเตอร์หมายเลข {$computerCODE} สำเร็จ";
        }else{
            $_SESSION['error'] = "ไม่สามารถยกเลิกการเชื่อมต่อคอมกับอุปกรณ์ได้สำเร็จ กรุณาติดต่อฝ่าย IT Support ทางเราจะแก้ไขปัญหาให้เร็วที่สุดขอบคุณครับ";
        }
        header("location: inventory/show_Inventory.php?computerID={$computerID}&computerCODE=$computerCODE");
        exit;
        break;
    case 'ConfirmInventories': // ส่งรายการตรวจสอบอุปกรณ์ให้กับผู้ดูแลห้อง
        // print_r($ARR_REQUEST);exit;
        $accountId = $ARR_REQUEST['accountID'];
        $roomId = $ARR_REQUEST['roomID'];
        $build = $ARR_REQUEST['build'];
        $floor = $ARR_REQUEST['floor'];
        $result = $classroomObj->updateStusComputerByRoomId($roomId, -1); // // เปลื่ยนสถานะคอมพิวเตอร์เป็น -1 'ว่ารอผู้ดูแลห้องตรวจสอบ'
        if($result){
            $accountObj->updateAccStus($accountId, -1); // สถานะ -1 ต้องยืนยันอุปกรณ์ก่อน
            $ownerClassDepartObj->updateStatusConfirmInventories($accountId); // ให้แจ้งเตือนโชว์ Alert
            $_SESSION['alert'] = "ส่งรายการไปให้ผู้ดูแลห้องตรวจสอบอุปกรณ์สำเร็จ กรุณารอการดำเนินการตรวจสอบอุปกรณ์จากผู้ดูแลห้อง";
        }
        header("location: rooms/show_rooms.php?build={$build}&floor={$floor}");
        exit;
        break;
    case 'InventoriesConfirmByOwnerRoom': // ผู้ดูแลห้องยืนยันอุปกรณ์แล้วจะมาทำรายการนี้
        // print_r($ARR_REQUEST);exit;
        $accountId = $ARR_REQUEST['accountID'];
        $roomId = $ARR_REQUEST['roomID'];
        $checkList = $ARR_REQUEST['checkList'];
        $stus=0;
        if($checkList == 'completeList') { // กรณีรายการครบ
            $accountObj->updateAccStus($accountId, 1); // สถานะ 1 สามารถเข้าใช้งานโปรแกรมได้ปกติ
            $_SESSION['status'] = 1;
            $stus=1;
        }else{ // กรณีรายการไม่ครบ
            $accountObj->updateAccStus($accountId, -1); // สถานะ -1 ต้องยืนยันอุปกรณ์ก่อน
            $ownerClassDepartObj->updateStatusConfirmInventories($accountId, 1); // ให้แจ้งเตือนโชว์ Alert
            $stus=0;
        }

        $result = $classroomObj->updateStusComputerByRoomId($roomId, $stus);
        if($result){
            if($stus==1){
                header('location: /repair-system/ClassroomOwner/index.php');
            }else {
                $_SESSION['alert_confirm_Inventories'] = "รอตรวจสอบอุปกรณ์จากผู้ดูแลระบบ ทางเราจะรีบดำเนินการให้เร็วที่สุด";
                header("location: inventory/details_Inventory_confirm.php?roomID={$roomId}&action=InventoriesConfirmByOwnerRoom");
            }
        }   
        exit;
        break;
}

header("location: rooms/index.php");

?>