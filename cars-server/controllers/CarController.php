<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/ResponseService.php");

class CarController {

    function getCarByID(){
        global $connection;

        if(isset($_GET["id"])){
            $id = $_GET["id"];
        }else{
            echo ResponseService::response(500, "ID is missing");
            return;
        }
        $car = CarService::findCarByID($id);
        echo ResponseService::response(200, $car);
        return;
    }

try {
            $method = $_SERVER['REQUEST_METHOD'];

            switch ($method) {
    
                case 'GET':
                    if (isset($_GET['id'])) {
                        echo CarService::findCarByID($_GET['id']);
                    } else {
                        echo CarService::getAllCars();
                    }
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"), true);
                    echo CarService::createCar($data);
                    break;
                case 'PUT':
                    if (!isset($_GET['id'])) {
                        echo ResponseService::response(400, ['error' => 'Missing ID for update']);
                        return;
                    }
                    $data = json_decode(file_get_contents("php://input"), true);
                    echo CarService::updateCar($_GET['id'], $data);
                    break;
                case 'DELETE':
                    if (!isset($_GET['id'])) {
                        echo ResponseService::response(400, ['error' => 'Missing ID for delete']);
                        return;
                    }
                    echo CarService::deleteCar($_GET['id']);
                    break;
                default:
                    echo ResponseService::response(405, ['error' => 'Method not allowed']);
                    break;
            }
        } catch (Exception $e) {
            echo ResponseService::response(500, ['error' => $e->getMessage()]);
            return;
        }
    }



?>