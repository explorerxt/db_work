<?php

// MySQL database configuration
$host = 'localhost';      // MySQL server host
$username = 'your_username';  // MySQL username
$password = 'your_password';  // MySQL password
$database = 'your_database';  // MySQL database name

// Read users data from file
$usersData = file_get_contents('users.json');
$users = json_decode($usersData, true);

// Connect to the MySQL database
$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Create the users table if it doesn't exist
$query = "CREATE TABLE IF NOT EXISTS users (
            user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            age INT(11),
            city VARCHAR(255)
          )";
$mysqli->query($query);

// Insert users data into the table
foreach ($users as $user) {
    $name = $mysqli->real_escape_string($user['name']);
    $email = $mysqli->real_escape_string($user['email']);
    $age = isset($user['age']) ? $user['age'] : null;
    $city = isset($user['city']) ? $mysqli->real_escape_string($user['city']) : null;

    $query = "INSERT INTO users (name, email, age, city) VALUES ('$name', '$email', '$age', '$city')";
    $mysqli->query($query);
}

// Close the database connection
$mysqli->close();

echo "Data has been imported into the MySQL database.";

?>
