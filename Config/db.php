<?php
// Database configuration
$host = "localhost";   // server (default kwa XAMPP)
$user = "root";        // default user
$pass = "";            // default password (blank in XAMPP)
$db   = "pharmacy_db"; // jina la database yako

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Optional: uncomment if you want to see success message during testing
// echo "Database connected successfully";
?>
