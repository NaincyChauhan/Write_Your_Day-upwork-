const userPasswords = document.querySelectorAll(".password");
const tooglePasswords = document.querySelectorAll(".password-toogle");

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

// Login Function
$(function() {
    $('#LogInForm').validate({
        rules: {
            email: "required",
            password: "required",
        },
        messages: {
            email: "Oops.! The email field is required.",
            password: "Oops.! The Password field is required.",
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
            console.log("funning is running well");
            var btn = $('#login'),
                form = $('#LogInForm');
            btn.attr('disabled', true);
            btn.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function(data) {
                    form[0].reset();
                    location.reload();                    
                    btn.attr("disabled", false);
                    btn.html('Login');
                },
                error: function(data) {
                    var msg = data.responseJSON.message,
                        error = "<ul>";

                    $.each(data.responseJSON.errors, function(key, value) {
                        error += "<li>" + value + "</li>";
                    });
                    error += "</ul>";
                    errorsHTMLMessage(error);                    
                    btn.attr("disabled", false);
                    btn.html('Login');
                }
            });

            return false;
        }
    });
});

// Register Script
$(function() {
    $('#registerform').validate({
        rules: {
            name: "required",
            username: "required",
            email: "required",
            phone: "required",
            dob: "required",
            password: "required",
            password_confirmation: "required",
            privacypolicy: "required",
        },
        messages: {
            name: "Oops.! The name field is required.",
            username: "Oops.! The Username field is required.",
            email: "Oops.! The email field is required.",
            phone: "Oops.! The Mobile field is required.",
            dob: "Oops.! The Date of Birth field is required.",
            password: "Oops.! The Password field is required.",
            password_confirmation: "Oops.! The Confirm Password field is required.",
            privacypolicy: "Oops.! The Privacy Policy field is required.",
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
            var btn = $('#registerBtn'),
                form = $('#registerform');
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
                        if (data.type != 1) {
                            $('#verify-otp').show();
                        } else {
                            form[0].reset();
                            location.reload();
                        }
                    } else {
                        ajaxMessage(0, data.message);
                    }
                    btn.attr("disabled", false);
                    // form[0].reset();
                    btn.html('Sign Up');
                },
                error: function(data) {
                    var msg = data.responseJSON.message,
                        error = "<ul>";

                    $.each(data.responseJSON.errors, function(key, value) {
                        error += "<li>" + value + "</li>";
                    });
                    error += "</ul>";
                    errorsHTMLMessage(error);
                    btn.attr("disabled", false);
                    btn.html('Sign Up');
                }
            });

            return false;
        }
    });
});

// Resend OTP
function resendOTP($this) {
    var btn = $('#registerBtn'),
        form = $('#registerform');
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
            btn.html('Submit');
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
            btn.html('Submit');
        }
    });
}

const overlay = document.querySelector(".overlay");
const closeOverlayBtn = document.querySelector(".cancel_btn");
let phoneInputField = document.querySelector("#user-tel");
const privacyLink = document.querySelector(".privacy_link")

const phoneInput = window.intlTelInput(phoneInputField, {
    initialCountry: "auto",
    geoIpLookup: getIp,
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
});

function getIp(callback) {
    fetch('https://ipinfo.io/json?token=7fa0a044d28330', {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then((resp) => resp.json())
        .catch(() => {
            return {
                country: 'us',
            };
        })
        .then((resp) => callback(resp.country));
}

privacyLink.onclick = () => overlay.classList.remove("hide");
closeOverlayBtn.onclick = () => overlay.classList.add("hide");