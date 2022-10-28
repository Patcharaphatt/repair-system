<?php

namespace App\Model;

use App\Database\Db;

class classroom extends Db {

    use functions;

    public function getAllBuild() {
         
        $sql = "
            SELECT
                room.Id,
                room.build
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

    public function getAllFloorByBuildName($buildName) {
         
        $sql = "
            SELECT
                room.Id,
                room.build,
                room.floor
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

    public function getAllRooms($build) {

        $sql = "
            SELECT
                room.Id,
                room.build,
                room.floor,
                room.name,
                room.status
                
            FROM
                room

            WHERE
                room.build = :build_Name AND room.floor = :floor
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($build);
        $data = $stmt->fetchAll();
        return $data;
    }


    public function addBuild($build) {

        $buildName = $build['build'];
        $numberOf_Floor = (int) $build['floor'];
        $numberOf_Room = (int) $build['room'];
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
 
}

?>