<?php
include '../db_connection.php'; // Include the database connection file

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$store_Id = $_POST['store_Id'];
$product_id = $_POST['product_id'];
$amount = $_POST['amount'];


// Insert data into the database
$insert_query = "INSERT INTO tickets (store_Id, product_id, amount) VALUES ('$store_Id','$product_id',  '$amount')";
        
if ($conn->query($insert_query) === TRUE) {
    echo "successful!";
                
    // Redirect to display_ticket_booker.html
    header("Location: display_ticket_booker.html");
    exit();
} else {
    echo "Error: " . $insert_query . "<br>" . $conn->error;
}



$conn->close();
?>
