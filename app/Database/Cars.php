<?php

define(
    "Cars_DB",
    __DIR__ . "/" . "Cars_db.json"
);
function readFromCarsMYSQL(): array
{
    $slots = [];
    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT id, name, description, image  FROM " . MYSQL_TABLE_CARS;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        echo "Error: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $slots[] = $row;
            }   
        }
    }
    $conn->close();
    return $slots;
}
function readFromCarsJSON(): array
{
    $arr = [];
    if (file_exists(Cars_DB)) {
        $json = file_get_contents(Cars_DB);
        $arr = json_decode($json, true);
    }

    return $arr;
}
function addDataToCarsMYSQL(string $name, string $description, string $image): void
{
    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . MYSQL_TABLE_CARS . " (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        image TEXT NOT NULL
    )";

    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($conn->query($createTableQuery) === true) {
        $stmt = $conn->prepare("INSERT INTO " . MYSQL_TABLE_CARS . " (name, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $image);

        if ($stmt->execute() === false) {
            echo "Cannot insert data into the database: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $conn->close();
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
    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM " . MYSQL_TABLE_CARS . " WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        return true;
    }   
    
    $conn->close();
}