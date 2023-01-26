$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#contactform').validate({
        rules: {
            name: "required",
            email: "required",
            mobile: "required",
            subject: "required",
            message: "required",
            myFile: "required",
            reCaptcha: {
                required: true,
                validCaptcha: true,
            },
        },
        messages: {
            name: "Oops.! The name field is required.",
            email: "Oops.! The Email Address is required.",
            mobile: "Oops.! The Mobile is required.",
            subject: "Oops.! The  Phone is required.",
            message: "Oops.! The Message field is required.",
            reCaptcha: "Oops.! The captcha field is required.",
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
            $('#submitontact').attr('disabled', true);
            $('#submitontact').html('<i class="far fa-paper-plane"></i> Sending...');

            $.ajax({
                type: 'POST',
                url: $('#contactform').attr('action'),
                data: $('#contactform').serialize(),

                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thank You 😊',
                        text: 'Thanks for contacting us. We will reach you soon.',
                    });
                    $('#submitontact').attr('disabled', false);
                    $('#submitontact').html('<i class="fa fa-paper-plane"></i> Get in Touch');
                    $('#contactform')[0].reset();
                },
                error: function(data) {
                    var msg = data.responseJSON.message,
                        error = "<ul>";

                    $.each(data.responseJSON.errors, function(key, value) {
                        error += "<li>" + value + "</li>";
                    });
                    error += "</ul>";
                    errorsHTMLMessage(msg + "<br>" + error);
                    $('#submitontact').attr('disabled', false);
                    $('#submitontact').html('<i class="fa fa-paper-plane"></i> Get in Touch');
                }
            });

            return false;
        }
    });
});