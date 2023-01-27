const userPasswords = document.querySelectorAll(".password");
const userEmail = document.querySelector("#user-email");
const tooglePasswords = document.querySelectorAll(".password-toogle");
const Error_Messages = ['email','password','otp'];
var message = $('#message');
let emailValue = userEmail.value;

for (let i = 0; i < tooglePasswords.length; i++) {
    tooglePasswords[i].onclick = () => {
        if (userPasswords[i].type === "password") {
            userPasswords[i].type = "text"
            tooglePasswords[i].classList.add("fa-eye")
            tooglePasswords[i].classList.remove("fa-eye-slash")

        } else {
            userPasswords[i].type = "password";
            tooglePasswords[i].classList.remove("fa-eye")
            tooglePasswords[i].classList.add("fa-eye-slash")
        }
    }
}
$('#send_otp').click(()=>{
    console.log("send otp function is running");
    console.log("email value",emailValue,userEmail);
    resendOTP();  
})

function resendOTP() {
    var btn = $('#send_otp'),        
        form = $('#resetPasswordform');
    var formData = new FormData(form[0]);
    formData.append("type", "otp");
    btn.attr('disabled', true);
    btn.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: formData, // serializes the form's elements.
        success: function(data) {
            clearErrors();
            if (parseInt(data.status) == 1) {
                MessageShow('#198754',data.message);
            } else {
                MessageShow('#dc3545',data.message);
            }
            btn.attr("disabled", false);
            btn.html('Resend code');
        },
        error: function(data) {
            clearErrors();
            $.each(data.responseJSON.errors, function(key, value) {
                $(`#${key}`+"_error").html(value);
            });
            btn.attr("disabled", false);
            btn.html('Resend code');
        }
    });
}

function clearErrors() {
    $.each(Error_Messages, function(key, value) {
        $(`#${value}`+"_error").html("");
    });
}

function MessageShow(color,msg) {
    message.css('color',color);
    message.html(msg);
    window.scrollTo(0, 0);
}

// Register Script
$(function() {
    $('#resetPasswordform').validate({
        rules: {
            email: "required",
            password: "required",
            password_confirmation: "required",
            otp: "required",
        },
        messages: {
            email: "Oops.! The email field is required.",
            password: "Oops.! The Password field is required.",
            password_confirmation: "Oops.! The Confirm Password field is required.",
            otp: "Oops.! The OTP field is required.",
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.legend').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(f) {
            var btn = $('#resetPasswordBtn'),
            form = $('#resetPasswordform');
            btn.attr('disabled', true);
            btn.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function(data) {
                    clearErrors();
                    if (parseInt(data.status) == 1) {
                        MessageShow('#198754',data.message);
                        if (data.type == 1) {
                            form[0].reset();
                            location.reload();
                        }
                    } else {
                        MessageShow('#dc3545',data.message);
                    }
                    btn.attr("disabled", false);
                    btn.html('Set Password');
                },
                error: function(data) {
                    clearErrors();
                    $.each(data.responseJSON.errors, function(key, value) {
                        $(`#${key}`+"_error").html(value);
                    });
                    btn.attr("disabled", false);
                    btn.html('Sign Up');
                }
            });

            return false;
        }
    });
});

