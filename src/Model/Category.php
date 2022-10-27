<?php

namespace App\Model;

use App\Database\Db;

class category extends Db {

    use functions;

    public function getAllCategories() { // แสดงข้อมูลทั้งหมด
        $sql = "
            SELECT
                category.Id AS Id,
                category.title AS categoryTitle
            FROM
                category
        ";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function addCategory($category) { // เพิ่มข้อมูล

        $result = $this->checkValuesRepeatDB('category', ['title'], [$category['categoryTitle']]);

        if($result === false) { 
            return false;
        }

        $sql = "INSERT INTO category (
            category.title
            ) VALUES (
                :category_Name
            )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($category);
        return $this->pdo->lastInsertId();
        
    }

    public function getCategoryById($Id) {

        $sql = "
            SELECT
                category.Id,
                category.title 
            FROM
                category
            WHERE
                category.Id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function updateCategory($category) {

        $result = $this->checkValuesRepeatDB('category', ['title'], [$category['category_Name']]);

        if($result === false) { 
            return false;
        }
       
        $sql = "UPDATE category SET
            category.title = :category_Name
            WHERE category.Id = :Id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($category);
        return true;
    }

    public function deleteCategory($Id) {

        // เช็ครายการอุปกรณ์ว่ามีรายการไอดีนี้ใช้งานอยู่มั้ย เพื่อกันข้อมูลสูญหายในหน้าอุปกรณ์ ?
        $result = $this->checkValuesRepeatDB('inventory', ['category_Id'], [$Id]);

        if($result === false) {
            return false;
        }

        $sql = "
            DELETE FROM category WHERE Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        return true;
    }
}

?>