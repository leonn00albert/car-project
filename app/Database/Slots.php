<?php

require  __DIR__ . "/" . "db_config.php";
define(
    "SLOT_DB",
    __DIR__ . "/" . "slots_options_db.json"
);


function readFromSlotsSQLite(): array
{
    $conn = new SQLite3("database.db");
    $selectQuery = "SELECT * FROM " . "slots";
    $result = $conn->query($selectQuery);
    $slots = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $slots[] = $row;
    }

    $conn->close();

    return $slots;
}
function addDataToSlotsSQLite(string $id, string $name): void
{
    $conn = new SQLite3("database.db");
    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . "slots" . " (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL
    )";
    $conn->exec($createTableQuery);
    $sql = "INSERT INTO " . "slots" . " (id, name) VALUES (null, '$name')";
    $conn->exec($sql);
    $conn->close();
}
function readFromSlotsJSON(): array
{
    $slots = [];
    if (file_exists(SLOT_DB)) {
        $json = file_get_contents(SLOT_DB);
        $slots = json_decode($json, true);
    }
    return $slots;
}
function addDataToSlotsJSON(string $id, string $name): void //change to right  type later
{

    if (is_writable(SLOT_DB)) {
        $slots = json_decode(file_get_contents(SLOT_DB), true);
        $slots[] = ["id" => $id, "name" => $name];
        if (!file_put_contents(SLOT_DB, json_encode($slots))) {
            echo "Cannot write to the file!";
        }
    }
}

function clearAndWriteTheSlotsJSON(): void
{
    if (is_writable(SLOT_DB)) {
        if (!file_put_contents(SLOT_DB, json_encode([]))) {
            echo "Cannot write to the file!";
        }
    }
}

function updateSlotsJSON(array $slots): void
{
    if (is_writable(SLOT_DB)) {
        if (!file_put_contents(SLOT_DB, json_encode($slots))) {
            echo "Cannot write to the file!";
        }
    }
}

function deleteSlotByID($id)
{

    if (file_exists(SLOT_DB)) {
        $json = file_get_contents(SLOT_DB);
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
            file_put_contents(SLOT_DB, json_encode($cars));

            return true;
        }
    }

    return false;
}
