<?php


define(
    "SLOT_DB",
    __DIR__ . "/" . "slots_options_db.json"
);


function readFromSlotsMYSQL(): array
{
    $slots = [];
    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      
      $sql = "SELECT id, name FROM " . MYSQL_TABLE_SLOTS;
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $slots[] = $row;
        }
      } 
      $conn->close();
    return $slots;
}
function addDataToSlotsMYSQL(string $id, string $name,): void
{
    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . MYSQL_TABLE_SLOTS . " (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    )";

    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($conn->query($createTableQuery) === true) {
        $sql = "INSERT INTO " . MYSQL_TABLE_SLOTS . " (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
    
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error creating table: " . $conn->error;
    }

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
    $conn = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM " . MYSQL_TABLE_SLOTS . " WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        return true;
    }   
    
    $conn->close();
}
