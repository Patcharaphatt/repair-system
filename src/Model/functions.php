<?php

namespace App\Model;

trait functions {

    private function checkValuesRepeatDB($Table_Name, $Select_Field_Name, $getValuesUser, $BOOL="true") { // เช็คข้อมูลซ้ำ
    
        $select = '';
        $where = '';
        $OR = 'OR';
        $Id = '';
    
        for($counter = 0; $counter < count($Select_Field_Name); $counter++) {
            $select.= "{$Table_Name}.{$Select_Field_Name[$counter]}"; // ใส่ค่าให้กับ select
            if ($counter < count($Select_Field_Name) -1) {
                $select.=',';
            }
    
            if ($counter != 0 && $counter < count($Select_Field_Name)) {
                $where.= "{$OR} {$Table_Name}.{$Select_Field_Name[$counter]} = {$getValuesUser[$counter]}"; // ใส่ค่าตัวแปรให้กับ where
            } else {
                $where.= "{$Table_Name}.{$Select_Field_Name[$counter]} = '{$getValuesUser[$counter]}'"; // ใส่ค่าตัวแปรให้กับ where
            }  
        }
    
        $sql = "
            SELECT
                {$select}
            FROM
                {$Table_Name}
            WHERE
                {$where}
        ";

        // echo $sql;exit;

        $stmt = $this->pdo->query($sql);
        $stmt->fetchAll();
        $countRow = $stmt->rowCount();
        // exit;
        
        if ($BOOL === "true") {
            if($countRow === 0) {
                return true;
            }else {
                return false;
            }
        }else {
            return $countRow;
        }
        
    }

}





?>