<?php


require  __DIR__ . "/Database/" . "db_config.php";
require_once __DIR__ . "/Actions/Cars.php";
require_once __DIR__ . "/Actions/Slots.php";
require_once __DIR__ . "/Actions/Users.php";
require_once __DIR__ . "/Actions/Reviews.php";
require_once __DIR__ . "/Actions/Bookings.php";
require_once __DIR__ . "/Actions/Day.php";
class Controller
{
    private Action $Cars;
    private Action $Slots;
    private Action $Reviews;
    private Bookings $Bookings;
    private Day  $Day;
    private Users  $Users;

    public function __construct(Action $Cars, Action $Slots, Bookings $Bookings, Day  $Day, $Users,Action $Reviews)
    {
        $this->Cars = $Cars;
        $this->Slots = $Slots;
        $this->Day = $Day;
        $this->Bookings = $Bookings;
        $this->Users = $Users;
        $this->Reviews = $Reviews;
    }
    function handleGet()
    {

        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["dates"])) {
            return $this->Bookings->read();
        }
    }

    function slots($date, $carId)
    {
        $filteredBookings = array_filter($this->Bookings->read(), function ($booking) use ($date, $carId) {
            $booking['date'] = json_decode($booking['date'], true);
            return $booking["carId"] === $carId && $booking['date']['date'] === $date;
        });

      
      
        if (count($filteredBookings) > 0) {
            $mergedSlots = [];
            $firstBooking = reset($filteredBookings);
            $firstBooking['date'] = json_decode($firstBooking['date'], true);
            foreach ($firstBooking['date']['slots'] as $slot) {
                if ($slot['available']) {
                    $mergedSlots[$slot['name']] = true;
                }
            }

            foreach ($filteredBookings as $booking) {
                            $booking['date'] = json_decode($booking['date'], true);

                $slots = $booking['date']['slots'];
                foreach ($slots as $slot) {
                    if ($slot['available'] && isset($mergedSlots[$slot['name']])) {
                        continue;
                    }
                    unset($mergedSlots[$slot['name']]);
                }
            }

            $slots = [];
            foreach (array_keys($mergedSlots) as $slot) {
                $slots[] = ["name" => $slot];
            }
            return $slots;
        } else {
            $res = $this->Day->create($date);
            return $res["slots"];
          
        }
    }
    function handlePost()
    {
        if (!empty($_POST["type"])) {

            if ($_POST["type"] === "cars") {
                try {
                    match ($_POST['action']) {
                        "create" => $this->Cars->create(),
                        "update" => $this->Cars->update(),
                        "delete" => $this->Cars->delete(),
                    };
                } catch (Exception $e) {
                    echo 'Message: ' . $e->getMessage();
                }
            }
            if ($_POST["type"] === "bookings") {
                try {
                    match ($_POST['action']) {
                        "create" => $this->Bookings->create(),
                        "update" => $this->Bookings->update(),
                        "delete" => $this->Bookings->delete(),
                    };
                } catch (Exception $e) {
                    echo 'Message: ' . $e->getMessage();
                }
            }
            if ($_POST["type"] === "users") {
                try {
                    match ($_POST['action']) {
                        "login" => $this->Users->login(),
                        "create" => $this->Users->create(),
                        "update" => $this->Users->update(),
                        "delete" => $this->Users->delete(),
                    };
                } catch (Exception $e) {
                    echo 'Message: ' . $e->getMessage();
                }
            }

            if ($_POST["type"] === "slot") {
                try {
                    match ($_POST['action']) {
                        "create" => $this->Slots->create(),
                        "update" => $this->Slots->update(),
                        "delete" => $this->Slots->delete(),
                    };
                } catch (Error $e) {
                    print_r($e);
                }
            }

            if ($_POST["type"] === "reviews") {
                try {
                    match ($_POST['action']) {
                        "create" => $this->Reviews->create(),
                        "update" => $this->Reviews->update(),
                        "delete" => $this->Reviews->delete(),
                    };
                } catch (Error $e) {
                    print_r($e);
                }
            }
            if ($_POST["type"] === "day") {
                try {
                    match ($_POST['action']) {
                       
                    };
                } catch (Error $e) {
                    print_r($e);
                }
            }
        }
    }
    function get(string $resource, $userId = "", $date = "", $id = "",): array
    {
        try {
            $result =  match ($resource) {
                "slot_options" => $this->Slots->read(),
                "cars" => $this->Cars->read(),
                "day" => $this->Day->create($date),
                "bookings" => $this->Bookings->read(),
                "reviews" => $this->Reviews->read(),
                "userBookings" => $this->Bookings->readUserBookings($userId),
                "users" => $this->Users->read(),
                "bookings/available" => $this->Bookings->available($id, $date),
                "bookings/cars/metrics" => $this->Bookings->getMostPopularCars(),
                default => throw new Exception("Invalid resource: $resource"),
            };
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
    function getCar($id): array
    {
        try {
            $result = [];
            foreach ($this->Cars->read() as $car) {
             
                if ($car["id"] == $id) {
                    $result = $car;
                }
            }

            return $result;
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    function getBookingById($id): array
    {
        try {
            return $this->Bookings->getBookingById($id);

        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }


}
// handle Form Data POST request

$controller = new Controller($Cars, $Slots, $Bookings, $Day, $Users, $Reviews);
$controller->handlePost();
$controller->handleGet();
