<?php
include '../db_connection.php'; // Include the database connection file

// Initialize variables
$store_Id = null;
$door_id = null;
$product_ids = array();
$amounts = array();
$door_ids = array();
$location_ids = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $store_Id = intval($_POST['store_Id']);

    // Retrieve data from the 'stores' table based on the store_Id
    $select_stores_query = $conn->prepare("SELECT door_id FROM stores WHERE store_Id = ?");
    if ($select_stores_query) {
        $select_stores_query->bind_param("i", $store_Id);

        if ($select_stores_query->execute()) {
            // Bind the result variable
            $select_stores_query->bind_result($door_id);

            // Fetch all results into an array
            while ($select_stores_query->fetch()) {
                $door_ids[] = $door_id;
            }

            // Close the result set
            $select_stores_query->close();
        } else {
            echo "Error executing query for stores: " . $select_stores_query->error;
        }
    } else {
        echo "Error preparing query for stores: " . $conn->error;
    }

    // Retrieve data from the 'tickets' table based on the store_Id
    $select_tickets_query = $conn->prepare("SELECT product_id, amount FROM tickets WHERE store_Id = ?");
    if ($select_tickets_query) {
        $select_tickets_query->bind_param("i", $store_Id);

        if ($select_tickets_query->execute()) {
            // Bind the result variables
            $select_tickets_query->bind_result($product_id, $amount);

            // Fetch all results into arrays
            while ($select_tickets_query->fetch()) {
                $product_ids[] = $product_id;
                $amounts[] = $amount;
            }

            // Close the result set
            $select_tickets_query->close();
        } else {
            echo "Error executing query for tickets: " . $select_tickets_query->error;
        }
    } else {
        echo "Error preparing query for tickets: " . $conn->error;
    }

    // Now, retrieve data from the 'products' table based on the product_id
    $select_products_query = $conn->prepare("SELECT location_id FROM products WHERE product_id = ?");
    if ($select_products_query) {
        // Prepare the statement outside the loop
        $select_products_query->bind_param("i", $product_id);

        // Loop through the product_ids and execute the query
        for ($i = 0; $i < count($product_ids); $i++) {
            // Bind parameters and execute the query for each product_id
            $select_products_query->bind_param("i", $product_ids[$i]);

            if ($select_products_query->execute()) {
                // Bind the result variables
                $select_products_query->bind_result($location_id);

                // Fetch the result
                $select_products_query->fetch();

                // Add the location to the array
                $location_ids[] = $location_id;
            } else {
                echo "Error executing location query: " . $select_products_query->error;
            }
        }

        // Close the location query outside the loop
        $select_products_query->close();
    } else {
        echo "Error preparing location query: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticker booker</title>
    <link rel="stylesheet" href="../styles.css">
    <script src="../script.js" defer></script>
    <style>
        .px-2 {
            padding-left: 0.5rem/* 8px */;
            padding-right: 0.5rem/* 8px */;
        }

        .py-1-custom {
            padding-bottom: 0.15rem/* 4px */;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-xl {
            font-size: 1.25rem/* 20px */;
            line-height: 1.75rem/* 28px */;
        }

        .bg-emerald-400 {
            --tw-bg-opacity: 1;
            background-color: rgb(52 211 153 / var(--tw-bg-opacity));
        }

        .border-neutral-300 {
            --tw-border-opacity: 1;
            border-color: rgb(212 212 212 / var(--tw-border-opacity));
        }

        .mt-1 {
            margin-top: 0.2rem/* 4px */;
        }

        .rounded-sm {
            border-radius: 0.225rem/* 2px */;
        }

        .ml-4 {
            margin-left: 1rem/* 16px */;
        }

        .hover\:bg-emerald-700:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(4 120 87 / var(--tw-bg-opacity));
        }

        .bg-sky-800 {
            --tw-bg-opacity: 1;
            background-color: rgb(7 89 133 / var(--tw-bg-opacity));
        }

        .hover\:bg-sky-950:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(8 47 73 / var(--tw-bg-opacity));
        }

        .my-1 {
            margin-top: 0.25rem/* 4px */;
            margin-bottom: 0.25rem/* 4px */;
        }

        #outputContainer { /* scrollbar container */
            max-height: 400px;
            overflow-y: auto;
        }

        .text-2xl {
            font-size: 1.5rem/* 24px */;
            line-height: 2rem/* 32px */;
        }

        .underline {
            text-decoration-line: underline;
        }

        .font-semibold {
            font-weight: 600;
        }

        .border-neutral-400 {
            --tw-border-opacity: 1;
            border-color: rgb(163 163 163 / var(--tw-border-opacity));
        }

        .col-span-1 {
            grid-column: span 1 / span 1;
        }

        .bg-red-300 {
            --tw-bg-opacity: 1;
            background-color: rgb(252 165 165 / var(--tw-bg-opacity));
        }

        .ml-1 {
            margin-left: 0.25rem/* 4px */;
        }

        .max-w-custom {
            max-width: 25%;
        }

        .p-2 {
            padding: 0.5rem/* 8px */;
        }

        .h-full {
            height: 100%;
        }

        .custom-checkbox {
            width: 80%;
            height: 80%;
            margin: 0;
        }

        /* .custom-checkbox:checked {
            put like a swisting animation like the twitter like animation
        } */

        .w-1\/6 {
            width: 20%;
        }

        .mx-6 {
            margin-left: 1.5rem/* 24px */;
            margin-right: 1.5rem/* 24px */;
        }

        .ml-12 {
            margin-left: 25%;
            margin-top: 1%;
        }


        .center-custom {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .border-neutral-300 {
            --tw-border-opacity: 1;
            border-color: rgb(212 212 212 / var(--tw-border-opacity));
        }

        .shadow-sm {
            --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }

        @media (max-width: 1024px) {
            .lg\:w-1\/2 {
                width: 50%;
            }
        }

        @media (max-width: 768px) {
            .md\:w-1\/2 {
                width: 50%;
            }
        }

        @media (max-width: 640px) {
            .sm\:w-full {
                width: 100%;
            }
        }

        .min-w-25-custom {
            min-width: 30%;
        }
        
    </style>
</head>

<body>

    <!-- m-0 p-0 bg-center bg-cover bg-no-repeat -->

    <form action="ticket_booker.php" method="post">
        <div class="bg-gray-100 min-h-screen flex items-center justify-center bg-center bg-cover bg-no-repeat"
            style="background-image: url('../img/university_blur.png');">
            <div class="rounded-lg min-w-25-custom shadow-lg bg-white p-6 space-y-6 border lg:w-1/2 md:w-1/2 sm:w-full border-gray-200 dark:border-gray-700">
                <div class="flex grid-cols-3 space-y-2">
                    <h1 class="text-xl mb-5 flex-1">
                    <p class="text-center"><a class=" font-bold text-2xl underline">Ticket:</a></p> 
                    <p><a class="ml-4 font-semibold">Store ID : </a><?php echo $store_Id; ?></p><?php foreach ($door_ids as $door_id) : ?>
                    <p><a class="ml-4 font-semibold">Door ID : </a><?php echo $door_id; ?></p><?php endforeach; ?>
                    </h1>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="font-bold my-1 flex flex-row grid-cols-4 border bg-slate-300 shadow-sm">
                            <div class="flex-1 max-w-custom flex-center center-custom">
                                <h5>Location</h5>
                            </div>
                            <div class="flex-1 max-w-custom flex-center center-custom">
                                <h5>Product</h5>
                            </div>
                            <div class="flex-1 max-w-custom flex-center center-custom">
                                <h5>Amount</h5>
                            </div>
                            <div class="flex-1 max-w-custom flex-center center-custom">
                                <h5>Status</h5>
                            </div>
                        </div>
                        <div id="outputContainer" class="border border-neutral-400">
                            <?php for ($i = 0; $i < count($product_ids); $i++) : ?>
                                <!-- build x amount of input field rows -->
                                <div id="outputRow<?php echo $i; ?>" class="border border-neutral-300 my-1 flex flex-row grid-cols-4">
                                    <div class="flex-1 max-w-custom flex-center">
                                        <p class="mx-6"><?php echo $location_ids[$i]; ?></p>
                                    </div>
                                    <div class="flex-1 max-w-custom flex-center">
                                        <p class="mx-6"><?php echo $product_ids[$i]; ?></p>
                                    </div>
                                    <div class="flex-1 max-w-custom flex-center">
                                        <p class="mx-6"><?php echo $amounts[$i]; ?></p>
                                    </div>
                                    <div class="flex-1 max-w-custom">
                                        <p class="flex h-full ml-12">
                                            <input type="checkbox" id="checkbox<?php echo $i; ?>" name="checkbox[]" value="<?php echo $i; ?>" class="custom-checkbox">
                                        </p>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function validateCheckboxes() {
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                var allChecked = true;

                for (var i = 0; i < checkboxes.length; i++) {
                    if (!checkboxes[i].checked) {
                        allChecked = false;
                        break;
                    }
                }

                if (allChecked) {
                    // Redirect to "complete_ticket.html"
                    window.location.href = 'complete_ticket.html';
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');

                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', validateCheckboxes);
                });
            });
        </script>
    </form>
</body>

</html>

