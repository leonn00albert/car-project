<?php
// SQLite database file path
$dbFile = "database.db";

// Create SQLite database connection
$conn = new SQLite3($dbFile);

// Create table if it doesn't exist
$tableName = "example_table";
$createTableQuery = "CREATE TABLE IF NOT EXISTS $tableName (
id INTEGER PRIMARY KEY,
name TEXT,
age INTEGER
)";
$conn->exec($createTableQuery);

// Insert data into the table
$insertQuery = "INSERT INTO $tableName (name, age) VALUES ('John Doe', 25)";
$conn->exec($insertQuery);

// Query data from the table
$selectQuery = "SELECT * FROM $tableName";
$result = $conn->query($selectQuery);

// Fetch and display the data
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo "ID: " . $row['id'] . ", Name: " . $row['name'] . ", Age: " . $row['age'] . "<br>";
}

// Close the database connection
$conn->close();
