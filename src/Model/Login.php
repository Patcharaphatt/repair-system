<?php

namespace App\Model;

use App\Database\Db;

class login extends Db {

    public function login($user) {

        $sql = "
            SELECT
                account.Id,
                account.username,
                account.password,
                account.fullname,
                account.email,
                account.status,
                role.title AS roleTitle
            FROM
                account
                LEFT JOIN role ON account.roleId = role.Id
            WHERE
                account.email = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user['email']]);
        $data = $stmt->fetchAll();
        $userDB = $data[0];

        if ($userDB['status'] == 1 || $userDB['status'] == -1) { // อนาคตจะต้องแก้ไขเงื่อนไข status ใหม่

            if(md5($user['password']) === $userDB['password']) {

                session_start();
                $_SESSION['Id'] = $userDB['Id'];
                $_SESSION['name'] = $userDB['fullname'];
                $_SESSION['email'] = $userDB['email'];
                $_SESSION['role'] = $userDB['roleTitle'];
                $_SESSION['status'] = $userDB['status'];
                $_SESSION['alert_welcome'] = '';
                $_SESSION['login'] = true;
                return true;

            } else {
                return false;
            }

		} else {
			return false;
		}
    }
}