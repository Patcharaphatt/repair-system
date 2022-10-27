<?php

namespace App\Model;

use App\Database\Db;

class Department extends Db {

    public function getAllDepartments() {
        $sql = "
            SELECT
                department.Id AS Id,
                department.title AS departTitle
            FROM
                department
        ";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function addDepartment($department) {


        $sql = "INSERT INTO department (
            department.title
            ) VALUES (
                :department_Name
            )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($department);
        return $this->pdo->lastInsertId();
    }

    public function deleteDepartment($Id) {
        $sql = "
            DELETE FROM department WHERE Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        return true;
    }

    public function getDepartmentById($Id) {

        $sql = "
            SELECT
                department.Id,
                department.title  
            FROM
                department
            WHERE
                department.Id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function updateDepartment($department) {
       
        $sql = "UPDATE department SET
            department.title = :department_Name
            WHERE department.Id = :Id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($department);
        return true;
    }
}

?>