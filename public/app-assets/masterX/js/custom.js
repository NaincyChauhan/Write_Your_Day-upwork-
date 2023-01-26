function loadDataTable() {
    $("#shivadatatable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#shivadatatable_wrapper .col-md-6:eq(0)');
}

$(function() {
    if ($("#shivadatatable").length) {
        loadDataTable();
    }

    $.validator.addMethod('validCaptcha', function(value, element) {
            return validateCaptcha(value, element.getAttribute('data-index'));
        },
        'Please enter a valid captcha code.'
    );
});


function ajaxMessage(status, msg) {
    if (status == 1) {
        Swal.fire({
            icon: 'success',
            title: 'Success! 😊',
            text: msg,
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error! 😯',
            text: msg,
        });
    }
}

function errorsHTMLMessage(msg) {
    Swal.fire({
        icon: 'error',
        title: 'Error! 😯',
        html: msg,
    });
}

function infoHTMLMessage(msg) {
    Swal.fire({
        icon: 'info',
        title: 'Info! 😐',
        showDenyButton: true,
        showCancelButton: true,
        html: msg,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {
            actions: 'my-actions',
            cancelButton: 'order-1 right-gap',
            confirmButton: 'order-2',
            denyButton: 'order-3',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            return true;
        } else if (result.isDenied) {
            return false;
        }
    });
}