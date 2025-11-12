<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/ResponseService.php");

class CarService {
    public static function getCars() {
        global $connection;
        try {
            $cars = Car::findAll($connection);
            $carsArray = array_map(fn($car) => $car->toArray(), $cars);
            return ResponseService::response(200, $carsArray);
        } catch (Exception $e) {
            return ResponseService::response(500, ['error' => $e->getMessage()]);
        }
    }
    public static function findCarByID($id) {
        global $connection;
        $id = (int)$id;
        try {
            $car = Car::find($connection, $id);
            if (!$car) {
                return ResponseService::response(404, ['message' => 'Car not found']);
            }
            return ResponseService::response(200, $car->toArray());
        } catch (Exception $e) {
            return ResponseService::response(500, ['error' => $e->getMessage()]);
        }
    }

    public static function createCar($data) {
        global $connection;
        try {
            if (empty($data['name']) || empty($data['color']) || empty($data['year'])) {
                return ResponseService::response(400, ['message' => 'Missing required fields']);
            }

            $newCar = new Car($data['name'], $data['color'], $data['year']);
            $newCar->save($connection);
            return ResponseService::response(201, ['message' => 'Car created successfully']);
        } catch (Exception $e) {
            return ResponseService::response(500, ['error' => $e->getMessage()]);
        }
    }
    public static function updateCar($id, $data) {
        global $connection;
        $id = (int)$id;
        try {
            $car = Car::find($connection, $id);
            if (!$car) {
                return ResponseService::response(404, ['message' => 'Car not found']);
            }

            $car->setName($data['name'] ?? $car->getName());
            $car->setColor($data['color'] ?? $car->getColor());
            $car->setYear($data['year'] ?? $car->getYear());
            $car->update($connection);

            return ResponseService::response(200, ['message' => 'Car updated successfully']);
        } catch (Exception $e) {
            return ResponseService::response(500, ['error' => $e->getMessage()]);
        }
    }

   