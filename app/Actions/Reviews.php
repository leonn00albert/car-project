<?php

require_once __DIR__ . '/Action.php';
require_once __DIR__ . '/../Database/Reviews.php';
class Reviews extends Action
{
    public function create(): bool

    //add form clean up here  for all inputs

    {
        $cleanData = [
            "rating" => trim(htmlspecialchars($_POST["rating"])),
            "carId" => trim(htmlspecialchars($_POST["carId"])),
            "userId" => trim(htmlspecialchars($_POST["userId"])),
        ];
        try {
            addDataToReviewsMYSQL(
                $cleanData["carId"],
                $cleanData["userId"],
                $cleanData["rating"],
            );
            header("location: /");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function read(): array
    {
        $data =  readFromReviewsMYSQL();
        return $data;
    }

    public function delete(): bool
    {
        if (isset($_POST["id"])) {
            header("location: /");
           
        }
        return false;
    }
}


$Reviews = new Reviews();
