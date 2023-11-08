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

        //Первое фото в массиве будет главным
        $main_img = $data['images'][0];
        //Все остальные фото
        $images =  json_encode(array_slice($data['images'], 1, 2));
    
        //добавление объявления
        $sql = "INSERT INTO classifieds (title, description, main_img, price, images) VALUES (:title, :description, :main_img, :price, :images)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":title", $data['title'], PDO::PARAM_STR);
        $stmt->bindValue(":description", $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(":main_img", $main_img, PDO::PARAM_STR);
        $stmt->bindValue(":price", $data['price'] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":images", $images ?? 0, PDO::PARAM_STR);

        $stmt->execute();

        $lastInsertId = $this->conn->lastInsertId();

        return $lastInsertId;
    }

    public function getOne(string $id, array $fields) : array | false 
    {
        
        $optionalParams = $fields ? ', ' . $fields['fields'] : '';
        
        $sql = "SELECT title, main_img, price $optionalParams FROM classifieds WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT); 
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}