 <?php
/*
define(
    "USERS_DB",
    __DIR__ . "/" . "USERS_DB.json"
);

function readFromUsersJSON(): array
{
    $users = [];
    if (file_exists(USERS_DB)) {
        $json = file_get_contents(USERS_DB);
        $users = json_decode($json, true);
    }
    return $users;
}

function addDataToUsersJSON(string $id, string $user, $email, $password, $type): void //change to right  type later
{
    /// make sure to add unique  email  if not throw error
    $users = json_decode(file_get_contents(USERS_DB), true);
    $users[] = ["id" => $id, "user" => $user, "email" => $email, "password" => $password, "type" => $type];
    if (!file_put_contents(USERS_DB, json_encode($users))) {
        echo "Cannot write to the file!";
    }
}

function clearAndWriteUsersJSON(): void
{
    if (is_writable(USERS_DB)) {
        if (!file_put_contents(USERS_DB, json_encode([]))) {
            echo "Cannot write to the file!";
        }
    }
}

function updateUsersJSON(array $Users): void
{
    if (is_writable(USERS_DB)) {
        if (!file_put_contents(USERS_DB, json_encode($Users))) {
            echo "Cannot write to the file!";
        }
    }
}
*/
?>

<?php


// Establish MySQL connection
$mysqli = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Create users table if it doesn't exist
$query = "CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(50) NOT NULL PRIMARY KEY,
    user VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL
)";
$mysqli->query($query);

function readFromUsersTable(): array
{
    global $mysqli;
    $users = [];

    $query = "SELECT * FROM users";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}

function addDataToUsersTable(string $id, string $user, $email, $password, $type): void
{
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO users (id, user, email, password, type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $id, $user, $email, $password, $type);

    if ($stmt->execute()) {
        echo "User added successfully.";
    } else {
        echo "Error: " . $mysqli->error;
    }

    $stmt->close();
}
?>
