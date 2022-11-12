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

    public function readListOfRepair($filters=[]) { // อ่านรายการซ่อม

        $where = '';
        // กรองข้อมูล
        if (isset($filters['filters'])) {
            if ($filters['filters']) {
                $where .= " AND {$this->TABLE_NAME}.rp_status = :filters";
            } else {
                unset($filters['filters']);
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
        ";

        echo $sql; exit;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($filters);
        $data = $stmt->fetchAll();
        return $data;
    }
 
}

?>