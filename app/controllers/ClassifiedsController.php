<?php 

namespace app\controllers;

use app\database\ClassifiedsGateway;
use app\validators\Validator;

class ClassifiedsController {

    public function __construct(private ClassifiedsGateway $gateway)
    {
        
    }

    

    public function processRequest(string $method, ?string $id, ?array $fields): void 
    {

        if ($id) {
            $this->processResourceRequest($method, $id, $fields);
        } else {
            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest(string $method, string $id, ?array $fields) {
        $ad = $this->gateway->getOne($id, $fields);

        echo json_encode($ad);

        if(!$ad) {
            http_response_code(404);
            echo json_encode(["message" => "Объявление не найдено"]);
            return;
        }
    }



    private function processCollectionRequest(string $method): void 
    {
        switch($method) {
            case "GET":
                $page = $_GET['page'] ?? null;
                $per_page = $_GET['per_page'] ?? null;
                echo json_encode($this->gateway->getAllClassifieds($page, $per_page), JSON_UNESCAPED_UNICODE);
                break;
                
            case "POST": 
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $validator = new Validator();
                $errors = $validator->validateAllFields($data);

                if(!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $id = $this->gateway->create($data);

                http_response_code(501);
                echo json_encode([
                    "message" => "Product created",
                    "id" => $id,
                ], JSON_UNESCAPED_UNICODE);

                break;
        }
    }

}