<?php 

namespace app\database;

use PDO;

class Db {
    public function getConnection() : PDO
    {
        $conf = require_once ROOT . '/config/config_db.php';
        return new PDO($conf['dsn'], $conf['user'], $conf['password'], [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]);
    }
}