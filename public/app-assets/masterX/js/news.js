$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#content').summernote({
        height: 300,
        fullscreen: false,
    });

    $('form').each(function() {
        if ($(this).data('validator'))
            $(this).data('validator').settings.ignore = ".note-editor *";
    });

    jQuery.validator.setDefaults({
        ignore: ":hidden, [contenteditable='true']:not([name])"
    });

    $('#addNewsForm').validate({
        rules: {
            title: "required",
            name: "required",
            desc: "required",
            image: "required",
            content: "required",
        },
        messages: {
            title: "Oops.! The title field is required.",
            name: "Oops.! The name field is required.",
            desc: "Oops.! The description field is required.",
            image: "Oops.! The image field is required.",
            content: "Oops.! The content field is required.",
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
        ignore: ":hidden, [contenteditable='true']:not([name])",
        submitHandler: function(f) {
            var btn = $('#addNewsBTN'),
                form = $('#addNewsForm');

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
                    } else {
                        ajaxMessage(0, data.message);
                    }
                    btn.attr("disabled", false);
                    form[0].reset();
                    $('#content').summernote('reset');
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

    //Edit
    $('#UpdateNewsForm').validate({
        rules: {
            title: "required",
            name: "required",
            desc: "required",
            content: "required",
        },
        messages: {
            title: "Oops.! The name field is required.",
            name: "Oops.! The name field is required.",
            desc: "Oops.! The name field is required.",
            content: "Oops.! The name field is required.",
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
            //ckeditorUpdate();
            var btn = $('#updateNewsBTN'),
                form = $('#UpdateNewsForm');
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
                    } else {
                        ajaxMessage(0, data.message);
                    }
                    btn.attr("disabled", false);
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
        url: "ajax/load-news-table",
        data: {},
        success: function(data) {
            $('#ajax_data_table').html(data);
            loadDataTable();
        },
        error: function(data) {
            ajaxMessage(0, "Something went wrong.!");
        }
    });
}