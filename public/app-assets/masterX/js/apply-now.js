$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#apply-now-modal-form').validate({
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
            var btn = $('#apply-now-modal-btn'),
                form = $('#apply-now-modal-form');
            btn.attr('disabled', true);
            btn.html('Sending...');

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),

                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Hurre.! 😊',
                        text: 'Your request has been recieved. We will ping you back soon.',
                    });
                    btn.attr('disabled', false);
                    btn.html('Submit');
                    form[0].reset();
                    $('#apply-now-modal').modal('hide');
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
                    btn.html('Submit');
                }
            });

            return false;
        }
    });
});