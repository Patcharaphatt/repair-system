<?php

namespace App\Model;

use App\Database\Db;

class ownerClassDepart extends Db {

    public function getAllOwnerClassDept($filters=[]) {
        
        $sql = "
            SELECT
                class_room_owner.Id,
                account.fullname AS ownerName,
                account.status AS status,
                department.title AS deptTitle,
                class_room_owner.account_Id,
                class_room_owner.department_Id,
                class_room_owner.room_Id

            FROM
                class_room_owner
                INNER JOIN account ON ( class_room_owner.account_Id = account.Id )
                INNER JOIN department ON ( class_room_owner.department_Id = department.Id )
            WHERE
                class_room_owner.Id > 0
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($filters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getOwnerClassDeptById($Id) {
        
        $sql = "
            SELECT
                class_room_owner.Id,
                account.fullname AS ownerName,
                department.title AS deptTitle,
                class_room_owner.account_Id,
                class_room_owner.department_Id,
                class_room_owner.room_Id

            FROM
                class_room_owner
                INNER JOIN account ON ( class_room_owner.account_Id = account.Id )
                INNER JOIN department ON ( class_room_owner.department_Id = department.Id )
            WHERE
                class_room_owner.Id = ?
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function readOwnerClassDeptByroomId($Id) { // class ใช้สำหรับต้องการข้อมูลของ db นี้แล้วใช้ Id ห้องอ้างอิง
        // echo $Id;exit;
        $sql = "
            SELECT
                class_room_owner.Id AS ID,
                class_room_owner.room_Id AS ROOMID,
                class_room_owner.Account_Id AS ACCOUNTID

            FROM
                class_room_owner

            WHERE
                class_room_owner.room_Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function readOwnerClassDeptByAccountId($Id) { // class ใช้สำหรับต้องการข้อมูลของ db นี้แล้วใช้ Id เจ้าของห้องอ้างอิง
        // echo $Id;exit;
        $sql = "
            SELECT
                class_room_owner.Id AS ID,
                class_room_owner.room_Id AS ROOMID,
                class_room_owner.Account_Id AS ACCOUNTID,
                class_room_owner.status_comfirm_inventory AS INVENTORY_CONFIRM_ALERT
                

            FROM
                class_room_owner

            WHERE
                class_room_owner.account_Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function addOwnerClassDept($ownerClassDept) {
        
        $sql = "INSERT INTO class_room_owner (

            class_room_owner.account_Id,
            class_room_owner.department_Id

        ) VALUES (

            :userById,
            :departById

        )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($ownerClassDept);
        return $this->pdo->lastInsertId();
    }

    public function updateOwnerClassDept($ownerClassDept) {

        $sql = "UPDATE class_room_owner SET
            class_room_owner.department_Id = :departById
            WHERE Id = :Id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($ownerClassDept);
        return true;
    }

    public function upDateRoom($roomId, $accountId) { // อัพเดทห้อง

        $sql = "UPDATE class_room_owner SET
            class_room_owner.room_Id = {$roomId}
            WHERE class_room_owner.account_Id = {$accountId}
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return true;

    }

    public function updateStatusConfirmInventories($accountId, $stus=0) { // อัพเดทสถานะการยืนยันอุปกรณ์ภายในห้อง

        $sql = "UPDATE class_room_owner SET
            class_room_owner.status_comfirm_inventory = {$stus}
            WHERE class_room_owner.account_Id = {$accountId}
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return true;

    }

    public function deleteOwnerClassDept($Id) {

        $result = $this->getOwnerClassDeptById($Id);
        $checked = $result['room_Id'];

        if($checked == 0) {

            $sql = "
                DELETE FROM class_room_owner WHERE Id = ?
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$Id]);
            return true;

        }else{
            return false;
        }

    }
 
}

?>