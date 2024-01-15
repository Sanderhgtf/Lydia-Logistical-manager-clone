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