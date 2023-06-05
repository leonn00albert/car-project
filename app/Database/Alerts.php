<?php
define(
    "ALERT_DB",
    __DIR__ . "/" . "alert_db.json"
);

function readFromSlotsJSON(): array
{
    $slots = [];
    if (file_exists(ALERT_DB)) {
        $json = file_get_contents(ALERT_DB);
        $slots = json_decode($json, true);
    }
    return $slots;
}

function addDataToAlerts(string $id, string $name): void //change to right  type later
{

    if (is_writable(ALERT_DB)) {
        $slots = json_decode(file_get_contents(ALERT_DB), true);
        $slots[] = ["id" => $id, "name" => $name];
        if (!file_put_contents(ALERT_DB, json_encode($slots))) {
            echo "Cannot write to the file!";
        }
    }
}

function clearAndWriteTheSlotsJSON(): void
{
    if (is_writable(ALERT_DB)) {
        if (!file_put_contents(ALERT_DB, json_encode([]))) {
            echo "Cannot write to the file!";
        }
    }
}

function updateSlotsJSON(array $slots): void
{
    if (is_writable(ALERT_DB)) {
        if (!file_put_contents(ALERT_DB, json_encode($slots))) {
            echo "Cannot write to the file!";
        }
    }
}

function deleteSlotByID($id)
{

    if (file_exists(ALERT_DB)) {
        $json = file_get_contents(ALERT_DB);
        $cars = json_decode($json, true);
        print $id;
        $index = null;
        foreach ($cars as $key => $car) {
            if ($car['id'] == $id) {
                $index = $key;
                break;
            }
        }

        if ($index !== null) {
            array_splice($cars, $index, 1);
            file_put_contents(ALERT_DB, json_encode($cars));

            return true;
        }
    }

    return false;
}
