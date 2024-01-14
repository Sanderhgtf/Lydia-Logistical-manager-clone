<?php
include '../db_connection.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $store_Id = intval($_POST['store_Id']);

    // Retrieve data from the database based on the store_Id
    $select_query = $conn->prepare("SELECT product_id, amount FROM tickets WHERE store_Id = ?");
    
    if ($select_query) {
        $select_query->bind_param("i", $store_Id);

        if ($select_query->execute()) {
            // Bind the result variables
            $select_query->bind_result($product_id, $amount);

            // Display results in a two-column area with a scrollbar
            echo '<!DOCTYPE html>
                  <html lang="en">
                  <head>
                      <meta charset="UTF-8">
                      <meta name="viewport" content="width=device-width, initial-scale=1.0">
                      <title>Ticket Viewer - Results</title>
                      <link rel="stylesheet" href="../styles.css">
                  </head>
                  <body>
                    <div class="max-h-80 overflow-y-auto mt-4 grid grid-cols-2 gap-4">
                    <strong>Store ID : '.$store_Id.'</strong>' ;
            while ($select_query->fetch()) {
                echo '<div class="border border-gray-300 p-2">' .
                    '<p><strong>Product / Amount : </strong>'.$product_id.' '.$amount.'</p>' .
                    '</div>';
            }
            echo '</div>
                  </body>
                  </html>';

            $select_query->close();
        } else {
            echo "Error executing query: " . $select_query->error;
        }
    } else {
        echo "Error preparing query: " . $conn->error;
    }
}

$conn->close();
?>