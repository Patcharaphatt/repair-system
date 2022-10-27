<?php

namespace App\Model;

use App\Database\Db;

class Role extends Db {

    public function getAllRolesById($Id) {

        $sql = "
            SELECT
                role.Id AS roleId,
                role.title AS roleTitle
            FROM
                role
            WHERE
                role.Id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    public function getAllRoles() {

        $sql = "
            SELECT
                role.Id AS roleId,
                role.title AS roleTitle
            FROM
                role
        ";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }
}

?>