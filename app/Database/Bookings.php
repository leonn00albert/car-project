<?php

define(
    "BOOKINGS_DB",
    __DIR__ . "/" . "bookings_db.json"
);

function readFromBookingsJSON(): array
{
    $bookings = [];
    if (file_exists(BOOKINGS_DB)) {
        $json = file_get_contents(BOOKINGS_DB);
        $bookings = json_decode($json, true);
    }

    return $bookings;
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

    if (file_exists(BOOKINGS_DB)) {
        $json = file_get_contents(BOOKINGS_DB);
        $bookings = json_decode($json, true);
        print $id;
        $index = null;
        foreach ($bookings as $key => $booking) {
            if ($booking['id'] == $id) {
                $index = $key;
                break;
            }
        }

        if ($index !== null) {
            array_splice($bookings, $index, 1);
            file_put_contents(BOOKINGS_DB, json_encode($bookings));

            return true;
        }
    }

    return false;
}
