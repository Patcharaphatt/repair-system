<?php

namespace App\Model;

use App\Database\Db;

class unit extends Db {

    use functions;

    public function getAllUnits() { // แสดงข้อมูลทั้งหมด
        $sql = "
            SELECT
                unit.Id AS Id,
                unit.title AS unitTitle
            FROM
                unit
        ";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function addUnit($unit) { // เพิ่มข้อมูล

        $result = $this->checkValuesRepeatDB('unit', ['title'], [$unit['unit_Name']]);

        if($result === false) { 
            return false;
        }

        $sql = "INSERT INTO unit (
            unit.title
            ) VALUES (
                :unit_Name
            )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($unit);
        return $this->pdo->lastInsertId();
        
    }

    public function getUnitById($Id) {

        $sql = "
            SELECT
                unit.Id,
                unit.title  
            FROM
                unit
            WHERE
                unit.Id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function updateUnit($unit) {

        $result = $this->checkValuesRepeatDB('unit', ['title'], [$unit['unit_Name']]);

        if($result === false) { 
            return false;
        }
       
        $sql = "UPDATE unit SET
            unit.title = :unit_Name
            WHERE unit.Id = :Id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($unit);
        return true;
    }

    public function deleteUnit($Id) {

        // เช็ครายการอุปกรณ์ว่ามีรายการไอดีนี้ใช้งานอยู่มั้ย เพื่อกันข้อมูลสูญหายในหน้าอุปกรณ์ ?
        $result = $this->checkValuesRepeatDB('inventory', ['unit_Id'], [$Id]);

        if($result === false) {
            return false;
        }

        $sql = "
            DELETE FROM unit WHERE Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        return true;
    }
}

?>