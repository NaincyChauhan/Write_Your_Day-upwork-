$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#request-form').validate({
        rules: {
            name: "required",
        },
        messages: {
            name: "Oops.! The name field is required.",
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
            var btn = $('#request-btn'),
                form = $('#request-form');
            btn.attr('disabled', true);
            btn.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
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
                    btn.html('<i class="mdi mdi-plus-circle-outline"></i> Add');
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
                    btn.html('<i class="mdi mdi-plus-circle-outline"></i> Add');
                }
            });
            return false;
        }
    });
});

$("#checkAll").on("click", function() {
    $('input:checkbox').not(this).prop('checked', this.checked);
});