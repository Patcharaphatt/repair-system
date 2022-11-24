<?php

namespace App\Model;
use App\Database\Db;


class repair extends Db {

    private $TABLE_NAME = "repair";

    use functions;

    public function createListOfRepair($arr) { // สร้างรายการแจ้งซ่อม

        $date = date("Y-m-d H:i:s"); // เก็บวันที่ปัจจุบันที่เพิ่มรายการแจ้งซ่อม

        $sql = "INSERT INTO repair (
            {$this->TABLE_NAME}.ownerRoom_Id,
            {$this->TABLE_NAME}.computer_Id,
            {$this->TABLE_NAME}.inventory_Id,
            {$this->TABLE_NAME}.rp_details,
            {$this->TABLE_NAME}.rp_img,
            {$this->TABLE_NAME}.rp_status,
            {$this->TABLE_NAME}.ownerRoom_notify_date

        ) VALUES (
            :ownerRoomID,
            :computerID,
            :inventoryID,
            :details,
            :Image,
            1,
            '{$date}'
        )
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($arr);
        return $this->pdo->lastInsertId();
    }

    public function readListOfRepair($filters=[], $LEVEL='') { // อ่านรายการซ่อม

        $where = '';
        // กรองข้อมูล
        if (isset($filters['filters'])) {
            if ($filters['filters']) {
                $where .= "AND {$this->TABLE_NAME}.rp_status = :filters";
            } else {
                unset($filters['filters']);
            }
        }

        // แสดงผลกรองตามสถานะ เช่น นาย A จะเห็นแค่เฉพาะรายการที่ตนเองแจ้งซ่อมเท่านั้น
        $SHOW_DATA = '';
        if($LEVEL !== '') {
            switch($LEVEL) {
                case 'ADMIN':
                    $SHOW_DATA .= "";
                    break;
                case 'OWNER_ROOM':
                    $SHOW_DATA .= "AND {$this->TABLE_NAME}.ownerRoom_Id = {$_SESSION['Id']}";
                    break;
                case 'TECHNICIAL':
                    $SHOW_DATA .= "AND {$this->TABLE_NAME}.technician_Id = {$_SESSION['Id']}";
                    break;
            }
        }
        
        $sql = "
            SELECT
                {$this->TABLE_NAME}.Id AS ID,
                {$this->TABLE_NAME}.ownerRoom_Id AS OWNERROOMID,
                {$this->TABLE_NAME}.computer_Id AS COMPUTERID,
                {$this->TABLE_NAME}.inventory_Id AS INVENTORYID,
                {$this->TABLE_NAME}.rp_details AS DETAILS,
                {$this->TABLE_NAME}.rp_status AS REPAIR_STATUS,
                {$this->TABLE_NAME}.rp_img AS OWNERROOM_IMG,
                {$this->TABLE_NAME}.ownerRoom_notify_date AS DATE_NOTIFY,
                class_room_owner.room_Id AS ROOMID,
                inventory.name AS INVENTORY_NAME,
                computer.code AS COMPUTER_CODE
            FROM
                repair
                INNER JOIN class_room_owner ON ({$this->TABLE_NAME}.ownerRoom_Id = class_room_owner.account_Id)
                INNER JOIN inventory ON ({$this->TABLE_NAME}.inventory_Id = inventory.Id)
                INNER JOIN computer ON ({$this->TABLE_NAME}.computer_Id = computer.Id)

            WHERE
            {$this->TABLE_NAME}.Id > 0
            {$where}
            {$SHOW_DATA}
        ";

        // echo $sql; exit;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($filters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function readListOfRepairById($Id) { // อ่านรายการซ่อมโดยอ้างอิงรายการซ๋อม
        $sql = "
            SELECT
                {$this->TABLE_NAME}.Id AS ID,
                {$this->TABLE_NAME}.ownerRoom_Id AS OWNERROOMID,
                {$this->TABLE_NAME}.computer_Id AS COMPUTERID,
                {$this->TABLE_NAME}.inventory_Id AS INVENTORYID,
                {$this->TABLE_NAME}.rp_details AS DETAILS,
                {$this->TABLE_NAME}.rp_status AS REPAIR_STATUS,
                {$this->TABLE_NAME}.rp_img AS OWNERROOM_IMG,
                {$this->TABLE_NAME}.ownerRoom_notify_date AS DATE_NOTIFY,
                {$this->TABLE_NAME}.admin_Id AS ADMINID,
                {$this->TABLE_NAME}.technician_Id AS TECHID,
                {$this->TABLE_NAME}.technician_operates_date AS DATE_TECH,
                {$this->TABLE_NAME}.description_job AS DESCRIPTION_DETAILS,
                {$this->TABLE_NAME}.rp_date_success AS DATE_SUCCESS,
                {$this->TABLE_NAME}.technicial_rp_img AS TECHNICIAL_IMG,
                class_room_owner.room_Id AS ROOMID,
                inventory.name AS INVENTORY_NAME,
                computer.code AS COMPUTER_CODE
            FROM
                repair
                INNER JOIN class_room_owner ON ({$this->TABLE_NAME}.ownerRoom_Id = class_room_owner.account_Id)
                INNER JOIN inventory ON ({$this->TABLE_NAME}.inventory_Id = inventory.Id)
                INNER JOIN computer ON ({$this->TABLE_NAME}.computer_Id = computer.Id)

            WHERE
            {$this->TABLE_NAME}.Id > 0
            AND {$this->TABLE_NAME}.Id = ?
        ";

        // echo $sql; exit;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function editListOfRepairById($arr) { // แก้ไขรายการซ่อม
        // print_r($arr);exit;
        $sql = "UPDATE repair SET
            {$this->TABLE_NAME}.computer_Id = :computerID,
            {$this->TABLE_NAME}.inventory_Id = :inventoryID,
            {$this->TABLE_NAME}.rp_details = :details,
            {$this->TABLE_NAME}.rp_img = :Image
            WHERE {$this->TABLE_NAME}.Id = :Id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($arr);
        return true;
    }

    public function updateStusListOfRepairById($Id, $statusId){ // เปลื่ยนสถานะรายการแจ้งซ่อม (ไอดีอ้างอิง, สถานะแจ้งซ่อม)
        $sql = "UPDATE repair SET
            repair.rp_status = {$statusId}
            WHERE repair.Id = {$Id}
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return true;
    }
}

?>