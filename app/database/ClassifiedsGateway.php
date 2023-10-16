<?php 

namespace app\database;

use PDO;

class ClassifiedsGateway 
{
    private PDO $conn;

    public function __construct($database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAllClassifieds(): array
    {
        $sql = 'SELECT * from classifieds';
        $stmt = $this->conn->query($sql);

        $data = [];

        while($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }
}