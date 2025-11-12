<?php
require_once(__DIR__ . "/../services/CarService.php");
require_once(__DIR__ . "/../services/ResponseService.php");

function getCars() {
    try {
        if (isset($_GET["id"])) {
            $id = (int) $_GET["id"];
            echo CarService::findCarByID($id);
            return;
        }

        echo CarService::getAllCars();
        return;
    } catch (Exception $e) {
        echo ResponseService::response(500, ["error" => $e->getMessage()]);
        return;
    }
}

// run
getCars();
?>

