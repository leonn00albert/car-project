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
    $sql = "SELECT *  FROM " . MYSQL_TABLE_CARS;
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

function updateCarsMYSQL($id, array $arr): void {
    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("UPDATE " . MYSQL_TABLE_CARS . " SET name=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("sssi", $arr["name"], $arr["description"], $arr["image"], $id);

    if ($stmt->execute() === false) {
        echo "Cannot update data in the database: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
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