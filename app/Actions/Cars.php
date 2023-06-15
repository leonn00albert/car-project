<?php

require_once __DIR__ . '/Action.php';
require_once __DIR__ . '/../Database/Cars.php';

class Cars extends Action
{
    public function create(): bool
    {
        $cleanData = [
            "name" => trim(htmlspecialchars($_POST["name"])),
            "description" => trim(htmlspecialchars($_POST["description"])),
            "image" => trim(htmlspecialchars(filter_input(INPUT_POST, "image", FILTER_VALIDATE_URL))),
        ];
        try {
            addDataToCarsMYSQL(
                $cleanData["name"],
                $cleanData["description"],
                $cleanData["image"]
            );
            header("location: /views/admin/carAdmin.php");
            return true;
        } catch (Exception $e) {
            print $e->getMessage();
            return false;
        }
    }
    public function update(): bool
    {
        $cleanData = [
            "name" => trim(htmlspecialchars($_POST["name"])),
            "description" => trim(htmlspecialchars($_POST["description"])),
            "image" => trim(htmlspecialchars(filter_input(INPUT_POST, "image", FILTER_VALIDATE_URL))),
        ];
        updateCarsMYSQL($_POST["id"], $cleanData);
        header("location: /views/admin/carAdmin.php");

        return true;
    }
    public function read(): array
    {
        $data = readFromCarsMYSQL();
        return $data;
    }

    public function delete(): bool
    {
        if (isset($_POST["id"])) {
            header("location: /views/admin/carAdmin.php");
            return deleteCarByID($_POST["id"]);
        }
        return false;
    }
}
$Cars = new Cars();
