function BlockPostRequest(btn) {
    var form = $(`#block_user_form`);
    btn.attr('disabled', true);
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            if (data.status==1) {                
                btn.attr("disabled", false);
                btn.html(data.message);
            }
        },
        error: function (data) {
            btn.attr("disabled", false);
        }
    });
}

function ShowUserReportModal(){
    $(`#report_user_container`).toggleClass('hide');
    $(`#user_profile_more_option`).toggleClass('hide');
}

// Post Report
$(function () {
    $('#user-report-form').validate({
        rules: {
            report: "required",
        },
        messages: {
            report: "Oops.! The Report field is required.",
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.main-form-class').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (f) {
            var form = $('#user-report-form'),
                btn = $('#user_send_report');
            btn.attr('disabled', true);
            btn.html('Sending...');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function (data) {
                    showLikeMessage(data.message);
                    btn.attr("disabled", false);
                    btn.html('Send');
                    $('#report_msg').val("");
                    $('#report_user_container').toggleClass('hide');
                },
                error: function (data) {
                    showLikeMessage(data.responseJSON.messages);
                    $.each(data.responseJSON.errors, function (key, value) {
                        $(".report_msg_error").html(value);
                    });
                    btn.attr("disabled", false);
                    btn.html('Send');
                }
            });
            return false;
        }
    });
});