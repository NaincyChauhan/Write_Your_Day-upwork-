const userPasswords = document.querySelectorAll(".password");
const tooglePasswords = document.querySelectorAll(".password-toogle");
const Error_Messages = ['email','username','name','dob','phone','password','privacypolicy'];
let message = $('#message');

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
                    location.reload();                    
                },
                error: function(data) {
                    $('#message').css('color','#dc3545');                
                    $('#message').html(data.responseJSON.message);                
                    window.scrollTo(0, 0);
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
            if (checkAge()) {                
                    clearErrors();
                    var btn = $('#registerBtn'),
                        form = $('#registerform');
                    var formdata = new FormData(form[0]);
                    btn.attr('disabled', true);
                    btn.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: false,
                        url: form.attr('action'),
                        data: formdata, // serializes the form's elements.
                        success: function(data) {
                            clearErrors();
                            if (parseInt(data.status) == 1) {                                
                                MessageShow('#fff',data.message);
                                if (data.type != 1) {
                                    $('#verify-otp').show();
                                } else {
                                    location.reload();
                                }
                            } else {
                                MessageShow('#dc3545',data.message);
                            }
                            btn.attr("disabled", false);
                            // form[0].reset();
                            btn.html('Sign Up');
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
            }else{
                $('#dob_error').html('You must be at least 12 years old to registration.');
                return false;
            }
            return false;
        }
    });
});


function clearErrors() {
    $.each(Error_Messages, function(key, value) {
        $(`#${value}`+"_error").html("");
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

function checkAge() {
    var dateField = document.getElementById("DOB");
    var today = new Date();
    var minAge = 12;
    var minDOB = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate());
    var dob = new Date(dateField.value);
    if (dob > minDOB) {
        return false;
    } else {
        return true;
    }
}

$("#username").on("input", function(event) {
    var regex = /^[a-zA-Z0-9_@]+$/;
    var username_error = $('#username_error');
    var register_btn =$('#registerBtn');
    username_error.css("text-align",'start');
    if (!regex.test($("#username").val())) {
        register_btn.attr("disabled", true);
        username_error.html("Username allow only characters, numbers and underscores");
    }else{
        register_btn.attr("disabled", false);
        username_error.html("");
    }
});

$("#user-tel").on("input", function() {
    var phone_error = $('#phone_error');
    var register_btn =$('#registerBtn');
    phone_error.css("text-align",'start');
    if ($("#user-tel").val().length == 10) {
        register_btn.attr("disabled", false);
        phone_error.html("");
    }else{
        register_btn.attr("disabled", true);
        phone_error.html("The phone must be at least 10 characters.");
    }
});

function resendOTP() {
    var btn = $('#send_otp'),        
        form = $('#registerform');
    $('#user-otp').val("");
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
                MessageShow('#fff',data.message);
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

function MessageShow(color,msg) {
    message.css('color',color);
    message.html(msg);
    window.scrollTo(0, 0);
}