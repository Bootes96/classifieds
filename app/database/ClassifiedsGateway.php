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

    public function create(array $data): string
    {
        var_dump($data);
        $sql = "INSERT INTO classifieds (title, description, main_img, price) VALUES (:title, :description, :main_img, :price)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":title", $data['title'], PDO::PARAM_STR);
        $stmt->bindValue(":description", $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(":main_img", $data['main_img'], PDO::PARAM_STR);
        $stmt->bindValue(":price", $data['price'] ?? 0, PDO::PARAM_INT);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }
}