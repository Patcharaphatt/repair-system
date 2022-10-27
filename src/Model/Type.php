<?php

namespace App\Model;

use App\Database\Db;

class type extends Db {

    use functions;

    public function getAllTypes() { // แสดงข้อมูลทั้งหมด
        $sql = "
            SELECT
                Type.Id AS Id,
                Type.title AS typeTitle
            FROM
                Type
        ";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function addType($type) { // เพิ่มข้อมูล

        $result = $this->checkValuesRepeatDB('type', ['title'], [$type['type_Name']]);

        if($result === false) { 
            return false;
        }

        $sql = "INSERT INTO type (
            type.title
            ) VALUES (
                :type_Name
            )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($type);
        return $this->pdo->lastInsertId();
        
    }

    public function getTypeById($Id) {

        $sql = "
            SELECT
                type.Id,
                type.title  
            FROM
                type
            WHERE
                type.Id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function updateType($type) {

        $result = $this->checkValuesRepeatDB('type', ['title'], [$type['type_Name']]);

        if($result === false) { 
            return false;
        }
       
        $sql = "UPDATE type SET
            type.title = :type_Name
            WHERE type.Id = :Id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($type);
        return true;
    }

    public function deleteType($Id) {

        // เช็ครายการอุปกรณ์ว่ามีรายการไอดีนี้ใช้งานอยู่มั้ย เพื่อกันข้อมูลสูญหายในหน้าอุปกรณ์ ?
        $result = $this->checkValuesRepeatDB('inventory', ['type_Id'], [$Id]);

        if($result === false) {
            return false;
        }

        $sql = "
            DELETE FROM type WHERE Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        return true;
    }
}

?>