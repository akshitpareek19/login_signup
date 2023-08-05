<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

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
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password'];

        // Verify the password using password_verify()
        if (password_verify($password, $hashedPassword)) {
            echo "Login successful! Welcome, " . $user['username'];
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "User not found. Please check your username.";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>

