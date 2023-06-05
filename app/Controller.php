<?php

require_once __DIR__ . "/Actions/Cars.php";
require_once __DIR__ . "/Actions/Slots.php";
require_once __DIR__ . "/Actions/Users.php";
require_once __DIR__ . "/Actions/Bookings.php";
require_once __DIR__ . "/Actions/Day.php";
class Controller
{
    private Action $Cars;
    private Action $Slots;
    private Bookings $Bookings;
    private Day  $Day;
    private Users  $Users;

    public function __construct(Action $Cars, Action $Slots, Bookings $Bookings, Day  $Day, $Users)
    {
        $this->Cars = $Cars;
        $this->Slots = $Slots;
        $this->Day = $Day;
        $this->Bookings = $Bookings;
        $this->Users = $Users;
    }
    function handleGet()
    {

        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["date"])) {
        }
    }

    function slots($date, $carId)
    {
        $filteredBookings = array_filter($this->Bookings->read(), function ($booking) use ($date, $carId) {
            return $booking["car_id"] === $carId && $booking['date']['date'] === $date;
        });

        if (count($filteredBookings) > 0) {
            $mergedSlots = [];
            $firstBooking = reset($filteredBookings);

            foreach ($firstBooking['date']['slots'] as $slot) {
                if ($slot['available']) {
                    $mergedSlots[$slot['name']] = true;
                }
            }

            foreach ($filteredBookings as $booking) {
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
            if ($_POST["type"] === "day") {
                try {
                    match ($_POST['action']) {
                        "create" => $this->Day->create(),
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
                "slot_options" => $this->Slots->Read(),
                "cars" => $this->Cars->Read(),
                "day" => $this->Day->create($date),
                "bookings" => $this->Bookings->read(),
                "userBookings" => $this->Bookings->readUserBookings($userId),
                "users" => $this->Users->read(),
                "bookings/available" => $this->Bookings->available($id, $date),
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
            foreach ($this->Cars->Read() as $car) {
                if ($car["id"] === $id) {
                    $result = $car;
                }
            }

            return $result;
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
}
// handle Form Data POST request

$controller = new Controller($Cars, $Slots, $Bookings, $Day, $Users);
$controller->handlePost();
$controller->handleGet();
