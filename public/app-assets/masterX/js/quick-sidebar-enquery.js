$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#quick-sidebar-form').validate({
        rules: {
            name: "required",
            email: "required",
            mobile: "required",
            subject: "required",
            message: "required",
        },
        messages: {
            name: "Oops.! The name field is required.",
            email: "Oops.! The Email Address is required.",
            subject: "Oops.! The  Phone is required.",
            message: "Oops.! The Message field is required.",
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
            var btn = $('#quick-enquiry-sidebar-form-submit-btn'),
                form = $('#quick-sidebar-form');

            btn.attr('disabled', true);
            btn.html(' <i class="far fa-paper-plane"></i> Sending...');

            $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]),
                success: function(data) {
                    if (parseInt(data.status) == 1) {
                        ajaxMessage(1, data.message);
                    } else {
                        ajaxMessage(0, data.message);
                    }
                    btn.attr('disabled', false);
                    btn.html(' <i class="far fa-paper-plane"></i> Send Message');
                    form[0].reset();
                },
                error: function(data) {
                    var msg = data.responseJSON.message,
                        error = "<ul>";

                    $.each(data.responseJSON.errors, function(key, value) {
                        error += "<li>" + value + "</li>";
                    });
                    error += "</ul>";
                    errorsHTMLMessage(msg + "<br>" + error);
                    btn.attr('disabled', false);
                    btn.html(' <i class="far fa-paper-plane"></i> Send Message');
                }
            });

            return false;
        }
    });
});