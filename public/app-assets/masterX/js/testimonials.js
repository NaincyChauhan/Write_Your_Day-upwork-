//validate
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addTestimonialForm').validate({
        rules: {
            name: "required",
            position: "required",
            image: "required",
            testimonial: "required",
        },
        messages: {
            name: "Oops.! The name field is required.",
            position: "Oops.! The position field is required.",
            image: "Oops.! The image field is required.",
            testimonial: "Oops.! The testimonial field is required.",
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
        submitHandler: function(f) {
            var btn = $('#addTestimonialBTN'),
                form = $('#addTestimonialForm');
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
                        ajaxMessage(1, data.message);
                        loadAjaxTable();
                    } else {
                        ajaxMessage(0, data.message);
                    }
                    btn.attr("disabled", false);
                    form[0].reset();
                    btn.html('<i class="mdi mdi-plus-circle-outline"></i> Save');
                    $('#addcategory').modal('hide');
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
            position: "required",
            testimonial: "required",
        },
        messages: {
            name: "Oops.! The name field is required.",
            position: "Oops.! The position field is required.",
            testimonial: "Oops.! The testimonial field is required.",
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
                        ajaxMessage(1, data.message);
                        loadAjaxTable();
                    } else {
                        ajaxMessage(0, data.message);
                    }
                    btn.attr("disabled", false);
                    form[0].reset();
                    btn.html('<i class="mdi mdi-plus-circle-outline"></i> Save');
                    $('#editcategory').modal('hide');
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

function callUpdate(e) {
    var url = e.attr('href');
    e.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
    $.ajax({
        type: "GET",
        url: url,
        data: {},
        success: function(data) {
            $('#editData').html(data);
            $('#editcategory').modal('show');
            e.html('Edit <i class="typcn typcn-edit btn-icon-append"></i>');
        },
        error: function(data) {
            ajaxMessage(0, "Something went wrong.!");
            e.html('Edit <i class="typcn typcn-edit btn-icon-append"></i>');
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
                    ajaxMessage(1, data.message);
                    loadAjaxTable();
                    e.html('Delete <i class="typcn typcn-delete-outline btn-icon-append"></i>');
                },
                error: function(data) {
                    ajaxMessage(0, "Something went wrong.!");
                    e.html('Delete <i class="typcn typcn-delete-outline btn-icon-append"></i>');
                }
            });
        }
    });
}

function loadAjaxTable() {
    $.ajax({
        type: "GET",
        url: "ajax/load-testimonial-table",
        data: {},
        success: function(data) {
            $('#ajax_data_table').html(data);
        },
        error: function(data) {
            ajaxMessage(0, "Something went wrong.!");
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