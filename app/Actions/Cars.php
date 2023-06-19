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
        $data = array_map(function($elm){ 
            $elm["average_rating"] = $this->readReviews($elm["id"]);
            return $elm;
         }, readFromCarsMYSQL());
        
        return $data;
    }
    public function readReviews($id)
    {
        $slots = [];
        $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM " . MYSQL_TABLE_REVIEWS . " WHERE carId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $slots[] = $row;
            }
        }
        $conn->close();
    
        $sum = 0;
        foreach ($slots as $rating) {
            $sum += (int)$rating["rating"];
        }
    
        $averageRating = count($slots) > 0 ? $sum / count($slots) : 0;
        return $averageRating;
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
