<?php

namespace App\Model;

use App\Database\Db;

class inventory extends Db {

    use functions;

    public function updateInventoryStus($Id ,$statusId) { // class สำหรับเปลื่ยนแปลงสถานะ status
        
        $sql = "UPDATE inventory SET
            inventory.status = {$statusId}
            WHERE inventory.Id = {$Id}
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return true;
    }

    public function readAllInventory() { // ตัวใหม่

        $sql = "
            SELECT
                inventory.Id AS ID,
                inventory.serial AS SERIAL,
                inventory.name AS INVENTORY_NAME,
                brand.Id AS BRANDID,
                brand.title AS BRAND_TITLE,
                category.Id AS CATEGORYID,
                category.title AS CATEGORY_TITLE,
                type.Id AS TYPEID,
                type.title AS TYPE_TITLE,
                unit.Id AS UNITID,
                unit.title AS UNIT_TITLE,
                COUNT(*) AS COUNT_INVENTORY_STOCK

            FROM
                inventory
                INNER JOIN brand ON ( inventory.brand_Id = brand.Id )
                INNER JOIN category ON ( inventory.category_Id = category.Id )
                INNER JOIN type ON ( inventory.type_Id = type.Id )
                INNER JOIN unit ON ( inventory.unit_Id = unit.Id )

            GROUP BY inventory.name
        ";
        
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function readInventorySerialByNameInventory($name) { // ดึงค่า serial number ของอุปกรณ์โดยอ้างอิงชื่ออุปกรณ์ใช้ดึงค่า ajax

        $sql = "
            SELECT
                inventory.Id AS ID,
                inventory.serial AS SERIAL,
                inventory.name AS INVENTORY_NAME,
                inventory.status AS STATUS

            FROM
                inventory

            WHERE
                inventory.name = ?
                AND inventory.status = 0
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name]);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getAllInventory() { // ตัวเก่าลบในอนาตค ต้องเขียนให้เสร็จก่อน ไปแก้ไขหน้า index floder inventory
        
        $sql = "
            SELECT
                inventory.Id,
                inventory.serial,
                inventory.name AS inventoryName,
                brand.Id AS brand_Id,
                brand.title AS brandTitle,
                category.Id AS category_Id,
                category.title AS categoryTitle,
                type.Id AS type_Id,
                type.title AS typeTitle,
                unit.Id AS unit_Id,
                unit.title AS unitTitle,
                COUNT(*) AS countInventoryStock

            FROM
                inventory
                INNER JOIN brand ON ( inventory.brand_Id = brand.Id )
                INNER JOIN category ON ( inventory.category_Id = category.Id )
                INNER JOIN type ON ( inventory.type_Id = type.Id )
                INNER JOIN unit ON ( inventory.unit_Id = unit.Id )
            GROUP BY inventoryName
        ";
        
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }


    public function getSubsetInventoryByName($invetory_Name) {
        
        $sql = "
            SELECT
                inventory.Id,
                inventory.serial,
                inventory.name AS inventoryName

            FROM
                inventory

            WHERE
                inventory.name = :inventory_Name
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($invetory_Name);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getInventoryById($Id) { // อันเก่า
        
        $sql = "
            SELECT
                inventory.Id,
                inventory.serial,
                inventory.name AS inventoryName,
                brand.Id AS brand_Id,
                brand.title AS brandTitle,
                category.Id AS category_Id,
                category.title AS categoryTitle,
                type.Id AS type_Id,
                type.title AS typeTitle,
                unit.Id AS unit_Id,
                unit.title AS unitTitle

            FROM
                inventory
                INNER JOIN brand ON ( inventory.brand_Id = brand.Id )
                INNER JOIN category ON ( inventory.category_Id = category.Id )
                INNER JOIN type ON ( inventory.type_Id = type.Id )
                INNER JOIN unit ON ( inventory.unit_Id = unit.Id )

            WHERE
                inventory.Id = ?
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function readInventoryById($Id) { // อันใหม่
        
        $sql = "
            SELECT
                inventory.Id AS ID,
                inventory.serial AS SERIAL,
                inventory.name AS INVENTORY_NAME,
                brand.Id AS brand_Id,
                brand.title AS brandTitle,
                category.Id AS category_Id,
                category.title AS categoryTitle,
                type.Id AS type_Id,
                type.title AS typeTitle,
                unit.Id AS unit_Id,
                unit.title AS unitTitle

            FROM
                inventory
                INNER JOIN brand ON ( inventory.brand_Id = brand.Id )
                INNER JOIN category ON ( inventory.category_Id = category.Id )
                INNER JOIN type ON ( inventory.type_Id = type.Id )
                INNER JOIN unit ON ( inventory.unit_Id = unit.Id )

            WHERE
                inventory.Id = ?
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function addInventory($inventory) {
        $serial = $inventory['serial']; // เก็บค่า serial number
        $inventory['serial'].='0001'; // นำ string มาต่อกันเพื่อที่จะนำค่านี้ไปเช็ครหัสอันแรกของรายการ
        $seialCheckRepeat = $this->checkValuesRepeatDB('inventory', ['serial'], [$inventory['serial']]); // เปรียบเทียบค่าซ้ำ

        if($seialCheckRepeat === false) { // เช็คว่าในระบบมี serial number ซ้ำมั้ย
            return 1;
        }

        $result = $this->checkValuesRepeatDB('inventory', ['name'], [$inventory['inventory_Name']]);
        if($result === false) { // เช็คชื่ออุปกรณ์ว่ามีซ้ำมั้ย
            return 2;
        }

        $stock = (int)$inventory['stock']; // แปลง stock จาก string เป็นตัวเลข
        $inventories = '';
        $runNumber='';

        for($n=1; $n<=$stock; $n++){
            $runNumber = str_pad($n,4,"0",STR_PAD_LEFT);
            $serialRun = $serial.$runNumber;
            $inventories .= "(
                            '{$serialRun}',
                            :inventory_Name, 
                            :brandId, 
                            :categoryId, 
                            :typeId, 
                            :unitId
                            )";

            if ($n<=$stock-1) {
                $inventories.=',';
            }
            $serialRun = '';
        }
        
        $sql = "INSERT INTO inventory (

            inventory.serial,
            inventory.name,
            inventory.brand_Id,
            inventory.category_Id,
            inventory.type_Id,
            inventory.unit_Id

        ) VALUES $inventories
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($inventory);
        return $this->pdo->lastInsertId();
    }


    public function updateInventory($inventory) {

        // เช็คว่ามีการเปลื่ยนรายการชื่ออุปกรณ์ไหม ถ้าเป็นจริงจะทำเงื่อนไขนี้
        // โดยการเปรียบเทียบจะเอา ช่องชื่ออุปกรณ์ที่ admin สามารถแก้ไขได้ มาเปรียบเทียบกับค่า getinventoryById ที่ดึงมาเปรียบเทียบ
        // ว่ามีค่าเท่ากันมั้ย ถ้ามีค่าเท่ากันก็ไม่ต้องเช็คว่ามีค่าซ้ำมั้ย ให้ทำการแก้ไขรายการได้เลย ..
        if ($inventory['inventory_Name'] != $inventory['get_inventory_Name_ById']) {
            $result = $this->checkValuesRepeatDB('inventory', ['name'], [$inventory['inventory_Name']]);
            if($result === false) { // เช็คชื่ออุปกรณ์ว่ามีซ้ำมั้ย
                return 1;
            }
        }
        

        $sql = "UPDATE inventory SET
            inventory.name = :inventory_Name,
            inventory.brand_Id = :brandId,
            inventory.category_Id = :categoryId,
            inventory.type_Id = :typeId,
            inventory.unit_Id = :unitId
            WHERE inventory.name = :get_inventory_Name_ById
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($inventory);
        return true;
    }

    public function deleteInventory($inventory_Name) {

            $sql = "
                DELETE FROM inventory WHERE inventory.name = ?
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$inventory_Name]);
            return true;

            // จะมาเพิ่มเติม function ทีหลัง ถ้ามีการผูกอุปกรณ์ไว้กับห้องจะไม่สามารถลบได้
    }
 
}

?>