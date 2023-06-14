<?php

define(
    "BOOKINGS_DB",
    __DIR__ . "/" . "bookings_db.json"
);

function readFromBookingsMYSQL(): array
{
    $slots = [];
    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, name, userId, date, carId, car FROM " . MYSQL_TABLE_BOOKINGS;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        echo "Error: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $slots[] = $row;
            }
        }
    }
    //$slots["dates"] = json_decode($slots["dates"],true); 

    $conn->close();
    return $slots;
}
function addDataToBookingsMYSQL(string $userId, string $name, $date, $carId, $car): void 
{
    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . MYSQL_TABLE_BOOKINGS . " (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        userId VARCHAR(255) NOT NULL,
        date TEXT NOT NULL,
        carId VARCHAR(255) NOT NULL,
        car VARCHAR(255) NOT NULL
    )";

    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($conn->query($createTableQuery) === true) {
        $sql = "INSERT INTO " . MYSQL_TABLE_BOOKINGS . " (name, userId, date, carId, car) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $userId, $date, $carId, $car);
    
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $conn->close();
}
function readFromBookingsJSON(): array
{
    $bookings = [];
    if (file_exists(BOOKINGS_DB)) {
        $json = file_get_contents(BOOKINGS_DB);
        $bookings = json_decode($json, true);
    }

    return $bookings;
}


function readUserBookingsMYSQL($userId): array
{
    $slots = [];
    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, name, userId, date, carId, car FROM " . MYSQL_TABLE_BOOKINGS . " WHERE userId = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        echo "Error: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $slots[] = $row;
            }
        }
    }

    $stmt->close();
    $conn->close();
    return $slots;
}
function readUserBookingsJSON($userId): array
{
    $bookings = [];

    if (file_exists(BOOKINGS_DB)) {
        $json = file_get_contents(BOOKINGS_DB);
        $allBookings = json_decode($json, true);

        $bookings = array_filter($allBookings, function ($booking) use ($userId) {
            return $booking['userId'] === $userId;
        });
    }

    return $bookings;
}


function addDataToBookingsJSON(string $id, string $userId, string $name,  $date, $carId, $car): void //change to right  type later
{

    $bookings = json_decode(file_get_contents(BOOKINGS_DB), true);
    $bookings[] = ["id" => $id, "userId" => $userId, "name" => $name, "date" => $date, "car_id" => $carId, "car" => $car];
    if (!file_put_contents(BOOKINGS_DB, json_encode($bookings))) {
        echo "Cannot write to the file!";
    }
}

function clearAndWriteBookingsJSON(): void
{
    if (is_writable(BOOKINGS_DB)) {
        if (!file_put_contents(BOOKINGS_DB, json_encode([]))) {
            echo "Cannot write to the file!";
        }
    }
}

function updateBookingsJSON($id, $date)
{
    if (file_exists(BOOKINGS_DB)) {
        $json = file_get_contents(BOOKINGS_DB);
        $bookings = json_decode($json, true);
        
        $found = false;
        foreach ($bookings as &$booking) {
            if ($booking['id'] == $id) {
                $booking["date"] = $date;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            echo "Booking not found!";
            return;
        }
        
        if (!file_put_contents(BOOKINGS_DB, json_encode($bookings))) {
            echo "Cannot write to the file!";
        } else {
            return true;
        }
    }
}




function deleteBookingById($id)
{

    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM " . MYSQL_TABLE_BOOKINGS . " WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        return true;
    }   
    
    $conn->close();
}
