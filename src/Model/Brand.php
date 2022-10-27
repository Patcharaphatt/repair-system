<?php

namespace App\Model;

use App\Database\Db;

class brand extends Db {

    use functions;

    public function getAllBrands() {
        $sql = "
            SELECT
                brand.Id AS Id,
                brand.title AS brandTitle
            FROM
                brand
        ";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function addBrand($brand) {

        $result = $this->checkValuesRepeatDB('brand', ['title'], [$brand['brand_Name']]);

        if($result === false) { 
            return false;
        }

        $sql = "INSERT INTO brand (
                brand.title
            ) VALUES (
                :brand_Name
            )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($brand);
        return $this->pdo->lastInsertId();
    }

    public function getBrandById($Id) {

        $sql = "
            SELECT
                brand.Id,
                brand.title  
            FROM
                brand
            WHERE
                brand.Id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function updateBrand($brand) {

        $result = $this->checkValuesRepeatDB('brand', ['title'], [$brand['brand_Name']]);

        if($result === false) { 
            return false;
        }
       
        $sql = "UPDATE brand SET
            brand.title = :brand_Name
            WHERE brand.Id = :Id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($brand);
        return true;
    }

    public function deleteBrand($Id) {

        // เช็ครายการอุปกรณ์ว่ามีรายการไอดีนี้ใช้งานอยู่มั้ย เพื่อกันข้อมูลสูญหายในหน้าอุปกรณ์ ?
        $result = $this->checkValuesRepeatDB('inventory', ['brand_Id'], [$Id]);

        if($result === false) {
            return false;
        }
        
        $sql = "
            DELETE FROM brand WHERE Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        return true;
    }
}

?>