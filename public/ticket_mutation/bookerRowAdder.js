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