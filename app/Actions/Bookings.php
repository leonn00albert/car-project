<?php
require_once __DIR__ . '/Action.php';
require_once __DIR__ . '/Email.php';
require_once __DIR__ . '/Day.php';
require_once __DIR__ . '/../Database/Bookings.php';
class Bookings extends Action
{

    //add form clean up here  for all inputs
    public function create(): bool
    {
        $day = new Day();
        try {
            $cleanData = [
                "userId" => trim(htmlspecialchars($_POST["userId"])),
                "name" => trim(htmlspecialchars($_POST["name"])),
                "time" => trim(htmlspecialchars($_POST["time"])),
                "date" => trim(htmlspecialchars($_POST["date"])),
                "carId" => trim(htmlspecialchars($_POST["carId"])),
                "car" => trim(htmlspecialchars($_POST["car"])),
                "email" => trim(htmlspecialchars($_POST["email"])),
            ];
            addDataToBookingsMYSQL(
                $cleanData["userId"],
                $cleanData["name"],
                json_encode($day->create($cleanData["date"], $cleanData["time"])),
                $cleanData["carId"],
                $cleanData["car"]
            );
            sendEmail($cleanData["email"], $cleanData["name"]);
            header("Location: /");
            return true;
        } catch (Exception $e) {
            print $e->getMessage();
            return false;
        }
    }
    public function update(): bool
    {
        $day = new Day();
        try {
            $cleanData = [
                "time" => trim(htmlspecialchars($_POST["time"])),
                "date" => trim(htmlspecialchars($_POST["date"])),
                "bookingId" => trim(htmlspecialchars($_POST["bookingId"])),
            ];
            updateBookingsJSON(
                $cleanData["bookingId"],
                $day->create($cleanData["date"], $cleanData["time"])
                
            );
            header("Location: /");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function read(): array
    {
        $data = readFromBookingsMYSQL();
        return $data;
    }

    public function readUserBookings($userId): array
    {
        $data = readUserBookingsMYSQL($userId);
        return $data;
    }

    public function available($id, $date): array
    {
        $filteredCars = array_filter(readFromBookingsJSON(), function ($car) use ($id, $date) {
            return $car['car_id'] == $id && $car['date']  === $date;
        });
        return $filteredCars;
    }

    public function getMostPopularCars(){
        $metrics = [];
        $bookings = $this->read();
        
        foreach($bookings as $booking){
            if (isset($metrics[$booking["car"]])) {
                $metrics[$booking["car"]] += 1;
            } else {
                $metrics[$booking["car"]] = 1;
            }
        }
        
        return $metrics;
    }
    public function delete(): bool

    // add later redirect to right location for admin
    {
        session_start();    
        if (isset($_POST["id"])) {
            if($_SESSION["type"] === "admin"){
                header("location: /views/admin/booking.php");
            }else{
                header("location: /views/user/userBookings.php");
            }
         
            return deleteBookingById($_POST["id"]);
        }
        return false;
    }
}


$Bookings = new Bookings();
