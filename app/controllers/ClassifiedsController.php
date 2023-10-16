<?php 

namespace app\controllers;

use app\database\ClassifiedsGateway;

class ClassifiedsController {

    public function __construct(private ClassifiedsGateway $gateway)
    {
        
    }

    public function processRequest(string $method, string $id) {
        if($id) {
            var_dump($id);
        } else {
            $this->processCollectionRequest($method);
        }
    }

    private function processCollectionRequest(string $method): void {
        switch($method) {
            case "GET":
                echo json_encode($this->gateway->getAllClassifieds(), JSON_UNESCAPED_UNICODE);
                break;
        }
    }
}