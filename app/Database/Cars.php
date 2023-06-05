<?php

define(
    "Cars_DB",
    __DIR__ . "/" . "Cars_db.json"
);

function readFromCarsJSON(): array
{
    $arr = [];
    if (file_exists(Cars_DB)) {
        $json = file_get_contents(Cars_DB);
        $arr = json_decode($json, true);
    }

    return $arr;
}

function addDataToCarsJSON(string $id, string $name,  $description,  $image): void //change to right  type later
{
    $arr = json_decode(file_get_contents(Cars_DB), true);
    $arr[] = [
        "id" => $id,
        "name" => $name,
        "image" => $image,
        "description" => $description,
        "dates" => []
    ];
    if (!file_put_contents(Cars_DB, json_encode($arr))) {
        echo "Cannot write to the file!";
    }
}

function clearAndWriteCarsJSON(): void
{
    if (is_writable(Cars_DB)) {
        if (!file_put_contents(Cars_DB, json_encode([]))) {
            echo "Cannot write to the file!";
        }
    }
}

function updateCarsJSON($id, array $arr): void {


    if (is_writable(Cars_DB)) {
        $json = file_get_contents(Cars_DB);
        $cars = json_decode($json, true);

     
        $index = null;
        foreach ($cars as $key => $car) {
            if ($car['id'] == $id) {
                $index = $key;
                break;
            }
        }

        if ($index !== null) {
            $arr["id"] = $id;
            $cars[$index] = $arr;

            $json = json_encode($cars, JSON_PRETTY_PRINT);
        
            $file = fopen(Cars_DB, 'w');
            if ($file === false) {
                echo "Cannot open the file!";
                return;
            }

            if (fwrite($file, $json) === false) {
                echo "Cannot write to the file!";
            }

            fclose($file);
        } else {
            echo "Car not found!";
        }
    } else {
        echo "The file is not writable!";
    }
}
function deleteCarByID($id) {

    if (file_exists(Cars_DB)) {
        $json = file_get_contents(Cars_DB);
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
            file_put_contents(Cars_DB, json_encode($cars));

            return true;
        }
    }

    return false; 
}