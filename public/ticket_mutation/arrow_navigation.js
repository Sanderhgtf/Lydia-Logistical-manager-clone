function handleArrowKeys(event, currentInput) {
    var inputRow = currentInput.parentElement.parentElement;

    // Handle arrow key events
    switch (event.key) {
        case 'ArrowUp':
            // Focus on the input in the row above
            if (inputRow.previousElementSibling) {
                inputRow.previousElementSibling.querySelector('input').focus();
            }
            break;
        case 'ArrowDown':
            // Focus on the input in the row below
            if (inputRow.nextElementSibling) {
                inputRow.nextElementSibling.querySelector('input').focus();
            }
            break;
        case 'ArrowLeft':
            // Focus on the input to the left
            if (currentInput.parentElement.previousElementSibling) {
                currentInput.parentElement.previousElementSibling.querySelector('input').focus();
            }
            break;
        case 'ArrowRight':
            // Focus on the input to the right
            if (currentInput.parentElement.nextElementSibling) {
                currentInput.parentElement.nextElementSibling.querySelector('input').focus();
            }
            break;
    }

    // Prevent the default behavior only for arrow keys
    if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(event.key)) {
        event.preventDefault();
    }
}

    // Attach event listeners to handle arrow key events
    document.addEventListener('keydown', function (event) {
        var activeElement = document.activeElement;

        // Check if the active element is an input field
        if (activeElement.tagName === 'INPUT') {
            handleArrowKeys(event, activeElement);
        }
    });