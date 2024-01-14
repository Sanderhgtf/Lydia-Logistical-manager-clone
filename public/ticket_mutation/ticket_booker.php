<?php
include '../db_connection.php'; // Include the database connection file

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$store_Id = $_POST['store_Id'];
$product_ids = $_POST['product_id'];
$amounts = $_POST['amount'];

// Loop through the arrays and insert data into the database
for ($i = 0; $i < count($product_ids); $i++) {
    $product_id = $product_ids[$i];
    $amount = $amounts[$i];

    // Check if the input fields are empty or have a value of 0
    if ($product_id != '' && $amount != '' && $amount != 0) {
        // Insert data into the database
        $insert_query = "INSERT INTO tickets (store_Id, product_id, amount) VALUES ('$store_Id', '$product_id', '$amount')";

        if ($conn->query($insert_query) !== TRUE) {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
            exit(); // Terminate if an error occurs
        }
    }
}

echo "Successful!";
// Redirect to display_ticket_booker.html
header("Location: display_ticket_booker.php");
exit();

$conn->close();
?>



<!-- 

This is an expanation of how you add data to the db by adding an index to the input field rows:

$_POST['product_id'] and $_POST['amount'] are now assumed to be arrays.
A loop is used to iterate over these arrays, fetching corresponding product_id and amount.
Inside the loop, each pair of product_id and amount is inserted into the database.

This way, for each cloned row with unique IDs, 
corresponding product_id and amount are processed individually in PHP, 
allowing you to insert multiple rows into the database.

 -->