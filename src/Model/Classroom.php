<?php

namespace App\Model;

use App\Database\Db;

class classroom extends Db {

    use functions;

    // class จัดการ ตึก/ชั้น/ห้อง
    public function createBuild($arr) { // สร้าง ตึก/ชั้น/ห้อง

        $buildName = $arr['build'];
        $numberOf_Floor = (int) $arr['floor'];
        $numberOf_Room = (int) $arr['room'];
        $insertRoom = '';
        $roomName = '';
        
        // เช็คว่า ชื่อตึกที่ใส่เข้ามามีซ้ำใน Database มั้ย ถ้ามีให้ return false
        $seialCheckRepeat = $this->checkValuesRepeatDB('room', ['build'], [$buildName]);

        // เช็คว่าชื่อตึกซ้ำกับในระบบมั้ย
        if($seialCheckRepeat === false) { 
            return 1;
        }

        for($floor=1; $floor<=$numberOf_Floor; $floor++) {
            $room=0;
            for($room=1; $room<=$numberOf_Room; $room++) {
                // รันเลขห้อง
                $roomNameRun = str_pad($room , 2, "0", STR_PAD_LEFT);
                $buildNameRunRoom = substr($buildName, -1);
                $roomName = "{$buildNameRunRoom}{$floor}{$roomNameRun}"; 
            
                $insertRoom .= "(
                    '{$buildName}',
                    '{$floor}',
                    '{$roomName}',
                    0
                ),";
            }
        }

        $insertRoom = substr($insertRoom,0, -1);

        $sql = "INSERT INTO room (

            room.build,
            room.floor,
            room.name,
            room.status

        ) VALUES $insertRoom
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function readAllBuild() { // class แสดงรายการตึกทั้งหมด
         
        $sql = "
            SELECT
                room.Id AS ID,
                room.build AS BUILD
            FROM
                room
                
            GROUP BY  
                room.build
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function readAllFloorByBuildName($buildName) { // class แสดงรายการชั้นทั้งหมดในตึกที่เลือก
         
        $sql = "
            SELECT
                room.Id AS ID,
                room.build AS BUILD,
                room.floor AS FLOOR
            FROM
                room

            WHERE
                room.build = ?
                
            GROUP BY  
                room.floor
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$buildName]);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function createRoom($arr) { // class สร้างห้องเรียน
        // print_r($arr);exit;
        $build = (int) $arr['build'];
        $floor = (int) $arr['floor'];
        $numberOf_Room = (int) $arr['NumberOfRoom'];
        $insertRoom = '';
        $roomName = '';

        $sql = "
            SELECT
                room.Id AS ID,
                room.build AS BUILD,
                room.floor AS FLOOR
                
            FROM
                room

            WHERE
                room.build = {$build} AND room.floor = {$floor}
        "; // นับจำนวน row ในชั้นที่เลือกว่ามีทั้งหมดเท่าไหร่

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $stmt->fetchAll();
        $rowCount = $stmt->rowCount();

        // set ค่าให้ลูปจำนวน
        $numberOf_Room += ($rowCount);
        $rowCount++;

        for($roomCount=$rowCount; $roomCount<=$numberOf_Room; $roomCount++){
            $roomNameRun = str_pad($roomCount , 2, "0", STR_PAD_LEFT);
            $roomName = "{$build}{$floor}{$roomNameRun}";
            $insertRoom.="(
                {$build},
                {$floor},
                {$roomName},
                0
            ),";
        }
        // print_r($insertRoom);exit;
        $insertRoom = substr($insertRoom,0, -1);

        $sql = "INSERT INTO room (

            room.build,
            room.floor,
            room.name,
            room.status

        ) VALUES $insertRoom
        ";
        // echo $sql;exit;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $this->pdo->lastInsertId(); 
    }

    public function readAllRooms($arr) { // class แสดงรายการห้องทั้งหมดของชั้นเรียนที่เลือก

        $sql = "
            SELECT
                room.Id AS ID,
                room.build AS BUILD,
                room.floor AS FLOOR,
                room.name AS ROOM_NUMBER,
                room.status AS STATUS
                
            FROM
                room

            WHERE
                room.build = :build AND room.floor = :floor
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($arr);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function deleteRoom($Id) { // class ลบรายการห้องเรียน
        // print_r($Id);exit;
        // เช็คว่าในห้องมีคอมพิวเตอร์มั้ย เพราะว่าถ้าจะลบห้อง ต้องเอารายการคอมพิวเตอร์ออกให้หมดก่อน ?
        $result = $this->checkValuesRepeatDB('computer', ['roomId'], [$Id]);
        // echo $result;exit;
        if($result === false) {
            return false;
        }   
        $sql = "
            DELETE FROM room WHERE Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        return true;
    }

    
    // ----------------------------

    // class จัดการคอมพิวเตอร์
    
    public function createComputer($arr) { // class สร้างคอมคอมพิวเตอร์

        // print_r($arr);exit;
        $InsertSQL = '';
        $runNumberComputer = 0;
        $roomId = $arr['roomID']; // เก็บรหัส room Id
        $roomCode = $arr['roomNUMBER']; // เก็บรหัสห้อง
        $numberOfComputer = (int) $arr['numberOfComputer']; // เก็บจำนวนคอมพิวเตอร์แล้วแปลงจาก string -> integer
        $countROW_REPEAT = $this->checkValuesRepeatDB('computer', ['roomId'],[$roomId], false);
        // echo $countROW_REPEAT;exit;
        // ที่ต้องตรวจสอบค่าซ้ำเพราะถ้าในอนาคตถ้าต้องการเพิ่มคอมพิวเตอร์อีกจะได้รันต่อจากเลขที่เคยเพิ่มแล้ว
        // เช่น เคยเพิ่มคอมพิวเตอร์แล้ว 50 เครื่อง แล้วต้องการเพิ่มอีก 10 เครื่อง funciton checkValuesRepeatDB จะทำการนับ
        // ว่ามีจำนวนเท่าไหร่หลังจากนั้นจะนำมาใส่ตัวแปร count เพื่อที่จะ Loop ค่าถัดจากตัวเลขเก่า
        $count=1; // ตัวแปรเก็บจำนวนลูปเครื่องคอมพิวเตอร์ ค่า default คือ 1
        if($countROW_REPEAT > 0){
            $count += $countROW_REPEAT;
            $numberOfComputer += $count-1;
        }

        for($count; $count<=$numberOfComputer; $count++) {
            $runNumberComputer = str_pad($count , 3, "0", STR_PAD_LEFT);
            $InsertSQL .= "('{$roomCode}-{$runNumberComputer}', {$roomId}, -2),";
        }

        $InsertSQL = substr($InsertSQL,0, -1); // เอาเครื่องหมาย ลูกน้ำ (,) ตัวสุดท้ายออก

        $sql = "INSERT INTO computer (
            computer.code,
            computer.roomId,
            computer.status
        ) VALUES $InsertSQL
        ";

        // echo $sql;
        // exit;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $this->pdo->lastInsertId();  
    }

    public function readAllComputersByRoomId($Id, $bool=true) { // class แสดงรายการคอมพิวเตอร์ทั้งหมดโดยอ้างอิง Id ห้อง ถ้าเป็นค่า false คือนับจำนวนคอมพิวเตอร์ทั้งหมดในห้องเรียน

        $COUNT='';
        // print_r($Id);exit;
        if($bool == false){
            $COUNT .= ',COUNT(computer.roomId) AS COUNT_COMPUTERID';
        }

        $sql = "
            SELECT
                computer.Id AS ID,
                computer.code AS CODE,
                computer.roomId AS ROOMID
                {$COUNT}
            FROM
                computer
            WHERE
                computer.roomId = ? 
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function readNumberOfInventoryByComId($Id) { // นับจำนวนอุปกรณ์ในคอมพิวเตอร์เครื่องอ้างอิงโดย computerId

        // print_r($Id);exit;

        $sql = "
            SELECT
                conect_inventory_computer.Id AS ID,
                COUNT(conect_inventory_computer.computerId) AS COUNT_COMPUTERID
               
            FROM
                conect_inventory_computer
            WHERE
                conect_inventory_computer.computerId = ? 
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
        
    }

    public function CheckStusComputersByRoomId($Id) { // เช็คสถานะคอมพิวเตอร์ว่าตรวจสอบรายการรึยัง
        // print_r($Id);exit;

        $sql = "
            SELECT
                computer.Id AS ID,
                computer.status AS COMPUTER_STATUS
               
            FROM
                computer
            WHERE
                computer.roomId = ?
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function updateStusComputerByRoomId($roomId, $stus) { // อัพเดทสถานะคอมพิวเตอร์
        $sql = "UPDATE computer SET
            computer.status = {$stus}
            WHERE computer.roomId = {$roomId}
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return true;
    }

    public function deleteComputer($Id) {
        // print_r($Id);exit;
        // เช็ครายการมีคอมพิวเตอร์เครื่องนี้มีการเชื่อมต่ออุปกรณ์อยู่มั้ย ถ้ามีจะไม่สามารถลบคอมพิวเตอร์เครื่องนี้ได้ ?
        $result = $this->checkValuesRepeatDB('conect_inventory_computer', ['computerId'], [$Id]);
        // echo $result;exit;
        if($result === false) {
            return false;
        }   
        $sql = "
            DELETE FROM computer WHERE Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        return true;
    }
    // ----------------------------

    // class จัดการอุปกรณ์เชื่อมต่อกับคอมพิวเตอร์
    public function connectInventoryToComputer($arr) { // class เชื่อมต่ออุปกรณ์กับคอมพิวเตอร์

        // print_r($arr);exit;

        $sql = "INSERT INTO conect_inventory_computer (
            conect_inventory_computer.computerId,
            conect_inventory_computer.inventoryId
        ) VALUES (
            :computerID,
            :inventoryID
        )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($arr);
        return $this->pdo->lastInsertId();  

    }

    public function readConnectInventoryToComputer($Id) { // class แสดงรายการอุปกรณ์ที่เชื่อมต่อกับคอมพิวเตอร์ อ้างอิงโดย computerId เพื่อกรองข้อมูล

        // print_r($Id);exit;

        $sql = "
            SELECT
                conect_inventory_computer.Id AS ID,
                conect_inventory_computer.computerId AS COMPUTERID,
                conect_inventory_computer.inventoryId AS INVENTORYID,
                computer.Id AS COMPUTERID,
                computer.Code AS CODE,
                inventory.Id AS INVENTORYID,
                inventory.name AS INVENTORY_NAME,
                inventory.serial AS SERIAL,
                inventory.status AS STATUS
            FROM
                conect_inventory_computer
                INNER JOIN inventory ON (conect_inventory_computer.inventoryId = inventory.Id)
                INNER JOIN computer ON (conect_inventory_computer.computerId = computer.Id)
            WHERE
                conect_inventory_computer.computerId = ? AND inventory.status=1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data;
        
    }

    public function cancelConnectInventoryToComputer($Id) {  // class ลบรายการที่ใช้อ้างอิงอุปกรณ์กับคอมพิวเตอร์ อ้างอิงโดย Id conect_inventory_computer เพื่อกรองข้อมูล
        // print_r($Id);exit;
        $sql = "
            DELETE FROM conect_inventory_computer WHERE conect_inventory_computer.Id = :connectID
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($Id);
        return true;
    }
    // ----------------------------

    // class อัพเดทสถานะเจ้าของห้อง
    public function UpdateStusOwnerClassroom($Id ,$StusId) { // class เปลื่ยนสถานะห้องให้เป็น 1 (มีเจ้าของห้องแล้ว)
        
        $sql = "UPDATE room SET
            room.status = {$StusId}
            WHERE room.Id = {$Id}
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return true;
    }
 
}

?>