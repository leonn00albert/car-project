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


function updateLastLogin($id)
{
    global $mysqli;
    $query = "UPDATE users
                SET last_login = CURRENT_TIMESTAMP
                WHERE id = ?";
                
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
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
