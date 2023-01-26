const userPasswords = document.querySelectorAll(".password");
const userEmail = document.querySelector("#user-email");
const tooglePasswords = document.querySelectorAll(".password-toogle");
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

// // Register Script
// $(function() {
//     $('#resetPasswordform').validate({
//         rules: {
//             email: "required",
//             password: "required",
//             password_confirmation: "required",
//             otp: "required",
//         },
//         messages: {
//             email: "Oops.! The email field is required.",
//             password: "Oops.! The Password field is required.",
//             password_confirmation: "Oops.! The Confirm Password field is required.",
//             otp: "Oops.! The OTP field is required.",
//         },
//         errorElement: 'span',
//         errorPlacement: function(error, element) {
//             error.addClass('invalid-feedback');
//             element.closest('.legend').append(error);
//         },
//         highlight: function(element, errorClass, validClass) {
//             $(element).addClass('is-invalid');
//         },
//         unhighlight: function(element, errorClass, validClass) {
//             $(element).removeClass('is-invalid');
//         },
//         submitHandler: function(f) {
//             console.log("form comming 121212");
//             var btn = $('#resetPasswordBtn'),
//                 form = $('#resetPasswordform');
//             btn.attr('disabled', true);
//             btn.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
//             $.ajax({
//                 type: "POST",
//                 processData: false,
//                 contentType: false,
//                 url: form.attr('action'),
//                 data: new FormData(form[0]), // serializes the form's elements.
//                 success: function(data) {
//                     if (parseInt(data.status) == 1) {
//                         ajaxMessage(1, data.message);
//                         if (data.type == 1) {
//                             form[0].reset();
//                             location.reload();
//                         }
//                     } else {
//                         ajaxMessage(0, data.message);
//                     }
//                     // btn.attr("disabled", false);
//                     // // form[0].reset();
//                     // btn.html('Set Password');
//                 },
//                 error: function(data) {
//                     var msg = data.responseJSON.message,
//                         error = "<ul>";

//                     $.each(data.responseJSON.errors, function(key, value) {
//                         error += "<li>" + value + "</li>";
//                     });
//                     error += "</ul>";
//                     errorsHTMLMessage(error);
//                     btn.attr("disabled", false);
//                     btn.html('Sign Up');
//                 }
//             });

//             return false;
//         }
//     });
// });

function resendOTP() {
    var btn = $('#send_otp'),
        form = $('#resetPasswordform');
    var formData = new FormData(form[0]);
    formData.append("type", "otp");
    btn.attr('disabled', true);
    btn.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
    // startCount(btn);
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: formData, // serializes the form's elements.
        success: function(data) {
            if (parseInt(data.status) == 1) {
                ajaxMessage(1, data.message);
            } else {
                ajaxMessage(0, data.message);
            }
            btn.attr("disabled", false);
            btn.html('Resend code');
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
            btn.html('Resend code');
        }
    });
}

// let CountD;
// let startCount = (countdown) => {
//     clearInterval(CountD);
//     let count = 60;
//     CountD = setInterval(() => {
//         countdown.html(`${count}s`);
//         count > 0 && count--;
//     }, 1000);
// }
