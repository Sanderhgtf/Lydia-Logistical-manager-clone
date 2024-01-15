<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticker booker</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../styles_ticket_general.css">
    <script src="arrow_navigation.js" defer></script>
    <script>
    let counter = 9;

    function addRow() {
        var container = document.getElementById('displayContainer');
        var inputRow = document.getElementById('inputRow0');
        var newRow = inputRow.cloneNode(true);
        newRow.id = 'inputRow' + counter;

        // Update input IDs using indexing
        newRow.querySelector('#product_id0').id = 'product_id' + counter;
        newRow.querySelector('#amount0').id = 'amount' + counter;

        container.appendChild(newRow);
        counter++;

        // If the number of rows exceeds x it adds scrollbar to container
        if (counter > 9) {
            container.style.overflowY = 'scroll';
        }
    }
    </script>
    <style>
        #displayContainer { /* scrollbar container */
            max-height: 400px;
            overflow-y: scroll;
        }
    </style>
</head>

<body>

    <!-- m-0 p-0 bg-center bg-cover bg-no-repeat -->

    <form action="ticket_booker.php" method="post">
        <div class="bg-gray-100 min-h-screen flex items-center justify-center bg-center bg-cover bg-no-repeat"
            style="background-image: url('../img/university_blur.png');">
            <div class="max-w-sm rounded-lg shadow-lg bg-white p-6 space-y-6 border border-gray-200 dark:border-gray-700">
                <div class="space-y-2 text-center">
                    <h1 class="text-3xl font-bold mb-5">Ticket booker</h1>
                </div>
                <div class="space-y-4">
                    <div class="flex flex-row grid-cols-3">
                        <div class="flex-1 space-y-2">
                            <input
                                class="flex h-10 w-full rounded-sm border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                id="store_Id" name="store_Id" placeholder="Store ID" required type="number" />
                        </div>
                        <div class="flex-1">
                            <button type="button" onclick="addRow()"
                                class="ml-4 mt-1 inline-flex text-xl items-center justify-center rounded-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 border border-neutral-300 border-input hover:bg-accent hover:text-accent-foreground px-2 py-1-custom font-bold hover:bg-emerald-700 bg-emerald-400 text-white">
                                +
                            </button>
                        </div>
                    </div>

                    <div id="displayContainer">
                        <!-- build x amount of nput field rows -->
                        <?php for ($i = 0; $i < 9; $i++) { ?>
                            <div class="my-1 flex flex-row grid-cols-3 space-x-2" id="inputRow<?php echo $i; ?>">
                                <div class="flex-1">
                                    <input
                                        class="h-10 w-full rounded-sm border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        id="product_id<?php echo $i; ?>" name="product_id[]" placeholder="Prod. ID"
                                        type="number" />
                                </div>
                                <div class="flex-1">
                                    <input
                                        class="flex h-10 w-full rounded-sm border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        id="amount<?php echo $i; ?>" name="amount[]" placeholder="amount"
                                        type="number" />
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 hover:bg-sky-950 bg-sky-800 text-white">
                            <div class="flex items-center justify-center">
                                Submit
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>
