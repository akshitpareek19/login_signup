<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    // Database connection parameters
    $host = 'db';
    $dbname = 'mydatabase';
    $dbuser = 'akshit';
    $dbpass = '123';

    // Create a new mysqli instance
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user exists in the database
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "User already exists in the database.";
    } else {
        // Insert the new user into the 'users' table
        $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $username, $hashedPassword, $email);
        $stmt->execute();

        echo "User successfully inserted into the database.";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>

