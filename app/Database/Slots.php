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
