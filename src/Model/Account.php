<?php

namespace App\Model;

use App\Database\Db;

class account extends Db {

    public function getAllAccount($filters=[], $statusId=1) { // select ข้อมูลทั้งหมด
        $userId = $_SESSION['Id'];
        $where = '';
        $status = '';

        $IdStus = 0;
        switch ($statusId) { // กรอง status ว่าจะ select account status ไหน

            case (-3):
                $IdStus = (-3);
                break;
            case (-2):
                $IdStus = (-2);
                break;
        }

        if ($statusId != 1) {
            $status .= "AND account.status = {$IdStus}";
        } else {
            $status = '';
        }

        // กรองข้อมูล
        if (isset($filters['roleId'])) {
            if ($filters['roleId']) {
                $where .= " AND role.Id = :roleId";
            } else {
                unset($filters['roleId']);
            }
        }
        
        $sql = "
            SELECT
                account.Id,
                account.fullname,
                account.email,
                role.title AS role      
            FROM
                account
                LEFT JOIN role ON account.roleId = role.Id
            WHERE
                account.Id > 0
                AND account.Id != {$userId}
                {$status}
                {$where}
        ";

        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($filters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function readAccountLevel($levelId) { // ดึงรายชื่อทั้งหมดตามสิทธิ์การใช้งาน
        $sql = "
            SELECT
                account.Id AS ID,
                account.fullname AS FULL_NAME

            FROM
                account
            WHERE
                account.Id > 0
                AND account.roleId = {$levelId}
        ";

        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($level);
        $data = $stmt->fetchAll();
        return $data;
    }


    public function readAllAccount($filters=[], $statusId=1) { // select ข้อมูลทั้งหมด (NEW)

        $userId = $_SESSION['Id'];
        $where = '';
        $status = '';

        $IdStus = 0;
        switch ($statusId) { // กรอง status ว่าจะ select account status ไหน

            case (-3):
                $IdStus = (-3);
                break;
            case (-2):
                $IdStus = (-2);
                break;
            case (-1):
                $IdStus = (-1);
                break;
        }

        if ($statusId != 1) {
            $status .= "AND account.status = {$IdStus}";
        } else {
            $status = '';
        }

        // กรองข้อมูล
        if (isset($filters['roleId'])) {
            if ($filters['roleId']) {
                $where .= " AND role.Id = :roleId";
            } else {
                unset($filters['roleId']);
            }
        }
        
        $sql = "
            SELECT
                account.Id AS ID,
                account.fullname AS FULL_NAME,
                account.email AS EMAIL,
                account.roleId AS ROLEID,
                role.title AS ROLE_TITLE

            FROM
                account
                LEFT JOIN role ON account.roleId = role.Id
            WHERE
                account.Id > 0
                AND account.Id != {$userId}
                {$status}
                {$where}
        ";

        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($filters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function addAccount($account) { // เพิ่มข้อมูลลง Table Account

        // เข้ารหัส md-5
        $account['password'] = password_hash($account['password'], PASSWORD_DEFAULT);

        // จัดการสถานะ
        // เจ้าของห้องให้ status = -3

        // เกณฑ์สถานะเจ้าของห้อง
        // -3 สถานะเพิ่งเพิ่ม
        // -2 เพิ่มแผนกแล้ว
        // -1 ขั้นตอนตรวจสอบอุปกรณ์ภายในห้อง
        // 0 ปิดการใช้งานบัญชีชั่วคราว
        // 1 ใช้งาน account ได้ตามปกติ

        $status = 0;
        if ($account['roleId'] == 3) {
            $status .= -3;
        } else {
            $status .= 1;
        }

        $sql = "INSERT INTO account (
            account.fullname,
            account.email,
            account.mobile,
            account.username,
            account.password,
            account.roleId,
            account.status
        ) VALUES (
            :fullname,
            :email,
            :mobile,
            :username,
            :password,
            :roleId,
            $status
        )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($account);
        return $this->pdo->lastInsertId();
    }

    public function deleteAccount($Id) {
        $sql = "
            DELETE FROM account WHERE Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        return true;
    }

    public function getAccountById($Id) { // class Select ข้อมูลตาม Id ที่ส่งมาจะ Return แค่ค่า Row เดียวเท่านั้น
        $sql = "
        SELECT
            account.Id,
            account.fullname,
            account.email,
            account.mobile,
            account.username,
            account.password,
            account.roleId    
        FROM
            account
        WHERE
            account.Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function readAccountById($Id) { // class Select ข้อมูลตาม Id ที่ส่งมาจะ Return แค่ค่า Row เดียวเท่านั้น (อันใหม่)

        // print_r($Id);exit;

        $sql = "
        SELECT
            account.Id AS ID,
            account.fullname AS FULL_NAME,
            account.email AS EMAIL,
            account.mobile AS MOBILE,
            account.username AS USERNAME,
            account.password AS PASSWORD,
            account.roleId AS ROLEID    
        FROM
            account
        WHERE
            account.Id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function updateAccStus($Id ,$statusId) { // class สำหรับเปลื่ยนแปลงสถานะ status

        $sql = "UPDATE account SET
            account.status = {$statusId}
            WHERE Id = {$Id}
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return true;

    }

    public function updateAccount($account) { // class อัพเดทข้อมูล

        $passwordDB = '';

        // ตรวจสอบว่า password มีการแก้ไขมั้ย
        if(isset($account['password'])) {
            
            if ($account['password'] != '') {
                $passwordDB .= ' ,account.password = :password';
                $account['password'] = md5($account['password']);
                
            } else {
                $passwordDB = '';
                unset($account['password']);
            }
        }
        
        
        $sql = "UPDATE account SET
            account.fullname = :fullname,
            account.email = :email,
            account.mobile = :mobile,
            account.username = :username
            $passwordDB
            WHERE Id = :Id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($account);
        return true;
    }
 
}

?>