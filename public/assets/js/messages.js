function ajaxMessage(status, msg) {
    if (status == 1) {
        Swal.fire({
            icon: 'success',
            title: 'Success! 😊',
            text: msg,
        });
    }
    else {
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
