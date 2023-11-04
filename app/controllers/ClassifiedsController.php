<?php 

namespace app\controllers;

use app\database\ClassifiedsGateway;
use app\validators\Validator;

class ClassifiedsController {

    public function __construct(private ClassifiedsGateway $gateway)
    {
        
    }

    public function processRequest(string $method, ?string $id) {
        if($id) {
            var_dump($id);
        } else {
            $this->processCollectionRequest($method);
        }
    }

    private function processCollectionRequest(string $method): void 
    {
        switch($method) {
            case "GET":
                echo json_encode($this->gateway->getAllClassifieds(), JSON_UNESCAPED_UNICODE);
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