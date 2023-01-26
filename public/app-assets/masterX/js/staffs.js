//validate
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#request-form-add').validate({
        rules: {
            name: "required",
            email: "required",
            role_id: "required",
            password: "required",
            // phone: "required",
        },
        messages: {
            name: "Oops.! The name field is required.",
            email: "Oops.! The email field is required.",
            role_id: "Oops.! The role field is required.",
            password: "Oops.! The password field is required.",
            // phone: "Oops.! The Phone field is required.",
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            var btn = $('#request-btn-add'),
                form = $('#request-form-add');
            btn.attr('disabled', true);
            btn.html('Saving <i class="mdi mdi-cloud-circle"></i>');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function(data) {
                    if (parseInt(data.status) == 1) {
                        ajaxDataTable()
                        ajaxMessage(1, data.message);
                        $('#addUser').modal('hide');
                    } else {
                        ajaxMessage(0, data.message);
                    }
                    btn.attr("disabled", false);
                    form[0].reset();
                    btn.html('<i class="mdi mdi-plus-circle-outline"></i> Save');
                },
                error: function(data) {
                    var msg = data.responseJSON.message,
                        error = "<ul>";

                    $.each(data.responseJSON.errors, function(key, value) {
                        error += "<li>" + value + "</li>";
                    });
                    error += "</ul>";
                    errorsHTMLMessage(msg + "<br>" + error);
                    btn.attr("disabled", false);
                    btn.html('<i class="mdi mdi-plus-circle-outline"></i> Save');
                }
            });
            return false;
        }
    });
});

function updateValidation() {
    $('#request-form-edit').validate({
        rules: {
            name: "required",
            email: "required",
            role_id: "required",
        },
        messages: {
            name: "Oops.! The name field is required.",
            email: "Oops.! The email field is required.",
            role_id: "Oops.! The role field is required.",
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            var btn = $('#request-btn-edit'),
                form = $('#request-form-edit');
            btn.attr('disabled', true);
            btn.html('Saving <i class="mdi mdi-cloud-circle"></i>');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function(data) {
                    if (parseInt(data.status) == 1) {
                        ajaxDataTable();
                        ajaxMessage(1, data.message);
                        $('#editUser').modal('hide');
                    } else {
                        ajaxMessage(0, data.message);
                    }
                    btn.attr("disabled", false);
                    form[0].reset();
                    btn.html('<i class="mdi mdi-plus-circle-outline"></i> Save');
                },
                error: function(data) {
                    var msg = data.responseJSON.message,
                        error = "<ul>";

                    $.each(data.responseJSON.errors, function(key, value) {
                        error += "<li>" + value + "</li>";
                    });
                    error += "</ul>";
                    errorsHTMLMessage(msg + "<br>" + error);
                    btn.attr("disabled", false);
                    btn.html('<i class="mdi mdi-plus-circle-outline"></i> Save');
                }
            });
            return false;
        }
    });
}

//Update Function
function callUpdateFunction(url) {
    $.ajax({
        type: 'get',
        url: url,
        data: {},
        success: function(data) {
            $('#editData').html(data);
            $('#editdiscount').modal('show');
        },
        error: function(error) {
            ajaxMessage(0, "Something went wrong.!");
        }
    });
}

function ajaxDataTable() {
    $.ajax({
        type: "GET",
        url: "ajax/load-staff-table",
        data: {},
        success: function(data) {
            $('#ajax_data_table').html(data);
        },
        error: function(data) {
            ajaxMessage(0, 'Something went wrong. Kindly refresh the page.');
        }
    });
}

function callUpdate(e) {
    var url = e.attr('href');
    e.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
    $.ajax({
        type: "GET",
        url: url,
        data: {},
        success: function(data) {
            $('#editData').html(data);
            $('#editUser').modal('show');
            e.html('<i class="mdi mdi-table-edit"></i> Edit');
        },
        error: function(data) {
            ajaxMessage(0, "Something went wrong.!");
            e.html('<i class="mdi mdi-table-edit"></i> Edit');
        }
    });
}

function callDelete(e) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Proceed!'
    }).then((result) => {
        if (result.isConfirmed) {
            var url = e.attr('href');
            e.html('Deleting <i class="mdi mdi-cloud-circle"></i>');
            $.ajax({
                type: "DELETE",
                url: url,
                data: {},
                success: function(data) {
                    $('#row' + data.row_id).remove();
                    ajaxDataTable();
                    ajaxMessage(1, data.message);
                    e.html('<i class="mdi mdi-delete-variant"></i> Delete');
                },
                error: function(data) {
                    ajaxMessage(0, "Something went wrong.!");
                    e.html('<i class="mdi mdi-delete-variant"></i> Delete');
                }
            });
        }
    });
}

function changeStatus(e) {
    var url = e.attr('href');
    $.ajax({
        type: "put",
        url: url,
        data: {},
        success: function(data) {
            ajaxMessage(1, data.message);
        },
        error: function(data) {
            ajaxMessage(0, "Something went wrong.!");
        }
    });
}