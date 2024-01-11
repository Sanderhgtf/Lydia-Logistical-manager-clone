<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dashboarddatabase";

// Create a connection to the database
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticket = $_POST["ticket"];
    $product_id = $_POST["product_id"];
    $amount = $_POST["amount"];

    // SQL query to insert data into the table
    $sql = "INSERT INTO order_picking (ticket, product_id, amount) VALUES ('$ticket', '$product_id', '$amount')";

    if ($conn->query($sql) === TRUE) {
        echo "Order added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
