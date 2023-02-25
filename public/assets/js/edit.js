//Tabs Layout Code
// //categories
const openCategoriesBtn = document.querySelectorAll('.open-categories-btn');
const closeCategoriesBtn = document.querySelector('.close-categories-btn');
const categoriesContainer = document.querySelector('.categories');
const profileLinks = document.querySelectorAll('.setting-link');
const profileContent = document.querySelectorAll('.setting');

for (let i = 0; i < openCategoriesBtn.length; i++) {
    openCategoriesBtn[i].onclick = () => categoriesContainer.classList.remove('hide');

}
closeCategoriesBtn.onclick = () => categoriesContainer.classList.add('hide');

for (let i = 0; i < profileLinks.length; i++) {
    profileLinks[i].onclick = () => {
        for (let j = 0; j < profileLinks.length; j++) {
            profileLinks[j].classList.remove('active');
        }
        profileLinks[i].classList.add('active');

        for (let index = 0; index < profileContent.length; index++) {
            profileContent[index].classList.remove('active');
            if (profileLinks[i].getAttribute('data-target') === profileContent[index].id) {
                profileContent[index].classList.add('active');
                categoriesContainer.classList.add('hide');
            }
        }
    }

}

//delete account
const deleteLink = document.querySelector(".disable-link");
const deleteQuesContainer = document.querySelector("#delete_container");
const deleteSteps = deleteQuesContainer.children;
const deleteBtn = document.querySelector("#delete_btn");
deleteLink.onclick = () => deleteQuesContainer.classList.remove("hide");

let proceedDeletion = () => {
    deleteQuesContainer.innerHTML = `
    <div class="password_box">
      <label for="password">Enter your password</label>
      <div class="input-group">
        <input type="password" name="password" id="password_check" required>
        <i class="fa fa-eye-slash icon" ></i>
      </div>
      <p class="confirm_password_error_1" id="pwd_error"></p>
      <div class="d-flex justify-content-between">
        <button  type="submit" id="delete_account_submit" class="d_btn suggested_btn" onclick="checkPassword()">Confirm Password</button>
        <button type="button" class="d_btn" onclick="closeBox()">Back to Profile</button>
      </div>
    </div>
  `;
    let showPwdBtn = document.querySelector(".password_box .icon");
    showPwdBtn.onclick = () => {
        if (showPwdBtn.previousElementSibling.type === "text") {
            showPwdBtn.previousElementSibling.type = "password";
            showPwdBtn.classList.replace("fa-eye", "fa-eye-slash");
            return;
        }
        showPwdBtn.previousElementSibling.type = "text";
        showPwdBtn.classList.replace("fa-eye-slash", "fa-eye");
    };
};

let checkPassword = () => {
    
}

// $(document).on('click', '.file-button', function() {
//     $('#my-file-input').click();
// });

let closeBox = () => {
    DeleteAccountContainer();
}

let LogoutNow = () => {
    DeleteAccountContainer();
    location.reload();  
}

function DeleteAccountContainer() {
    deleteQuesContainer.classList.add("hide");
    setTimeout(() => {
        deleteQuesContainer.innerHTML = `
        <div class="ques_box ques_box_1">
        <p class="ques_txt">Are you sure you want to delete this account? 
        </p>
        <div class="d-flex justify-content-between mx-4">
            <input type="hidden" name="password" id="delete-confirm-password">
            <button type="submit" class="ques_btn" id="delete_btn" onclick="proceedDeletion()">
                Yes
            </button>
            <button type="button" class="ques_btn suggested_btn text-primary" onclick="closeBox()">
                No
            </button>
        </div>
    </div>
  `
    }, 1000)
}

// Change User Email
const userEmail = $('#user-email');
let email_btn = $('#change-email-btn');
let edit_email_btn = $('#edit-email-btn');
let emailMessage = $('#email_message');
const email_opt_box = $('#email-otp-box');
const cancel_edit_email = $('#cancel-edit-email');

function EditUserEmail() {
    userEmail.attr('readonly', false)
    edit_email_btn.css('display', 'none');
    email_btn.css('display', 'block');
    $('#cancel-edit-email').css('display', 'block');
}

function CancelEditEmail(obj) {
    userEmail.attr('readonly', true);
    userEmail.val(userEmail.attr('oldValue'));
    edit_email_btn.css('display', 'block');
    email_btn.css('display', 'none');
    obj.css('display', 'none');
    emailMessage.html("");
    email_opt_box.css('display', 'none');
    email_opt_box.val("");
}

function ChangeUserEmail() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (userEmail.val() == "") {
        emailMessage.addClass("error");
        emailMessage.html("Email is required")
        return;
    } else if (!(userEmail.val().includes("@") && userEmail.val().includes("."))) {
        emailMessage.addClass("error");
        emailMessage.html("Invalid Email")
        return
    } else {
        emailMessage.html("")
    }
    // Sending Post Request.....
    email_btn.attr("disabled", true);
    email_btn.html('Requesting');
    $.ajax({
        type: "POST",
        url: $('#edit-profile-form').attr('action'),
        data: {
            "email": userEmail.val(),
            "otp": email_opt_box.val(),
            "type": 1,
        },
        success: function (data) {
            if (parseInt(data.status) == 1) {    // Success
                emailMessage.addClass("text-success");
                emailMessage.html(data.message)
                if (parseInt(data.type) == 0) {
                    email_opt_box.css("display", "block");
                    email_btn.html('Verify');
                }
                if (parseInt(data.type) == 1) {
                    email_opt_box.css("display", "none");
                    userEmail.attr('readonly', true);
                    email_opt_box.val("");
                    email_btn.css("display", "none");
                    edit_email_btn.css('display', 'block');
                    cancel_edit_email.css('display', 'none');
                    email_btn.html('Change');
                }
            } else {  // Failed
                emailMessage.addClass("error");
                emailMessage.html(data.message)
                email_btn.html('Verify');
            }
            email_btn.attr("disabled", false);
        },
        error: function (data) { // Failed
            emailMessage.addClass("error");
            emailMessage.html(data.responseJSON.message);
            email_btn.attr("disabled", false);
            email_btn.html('Change');
        }
    });
}

// Change User Phone
// HOLD..
// $(function (){
//     const userPhone = $('#user-phone');
//     let phone_btn = $('#change-phone-btn');
//     let edit_phone_btn = $('#edit-phone-btn');
//     let phoneMessage = $('#phone_message');
//     const phone_opt_box = $('#phone-otp-box');
//     const cancel_edit_phone = $('#cancel-edit-phone');

//     function EditUserPhone() {
//         userPhone.attr('readonly', false)
//         edit_phone_btn.css('display', 'none');
//         phone_btn.css('display', 'block');
//         $('#cancel-edit-phone').css('display', 'block');
//     }

//     function CancelEditPhone(obj) {
//         userPhone.attr('readonly', true);
//         userPhone.val(userPhone.attr('oldValue'));
//         edit_phone_btn.css('display', 'block');
//         phone_btn.css('display', 'none');
//         obj.css('display', 'none');
//         phoneMessage.html("");
//         phone_opt_box.css('display', 'none');
//         phone_opt_box.val("");
//     }

//     function ChangeUserPhone() {
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });
//         // Sending Post Request.....
//         phone_btn.attr("disabled", true);
//         phone_btn.html('Requesting');
//         $.ajax({
//             type: "POST",
//             url: $('#edit-profile-form').attr('action'),
//             data: {
//                 "phone": userPhone.val(),
//                 "otp": phone_opt_box.val(),
//                 "type": 2,
//             },
//             success: function (data) {
//                 phoneMessage.css('display','block');
//                 if (parseInt(data.status) == 1) {    // Success
//                     phoneMessage.addClass("text-success");
//                     phoneMessage.html(data.message)
//                     if (parseInt(data.type) == 0) {
//                         phone_opt_box.css("display", "block");
//                         phone_btn.html('Verify');
//                     }
//                     if (parseInt(data.type) == 1) {
//                         phone_opt_box.css("display", "none");
//                         userPhone.attr('readonly', true);
//                         phone_opt_box.val("");
//                         phone_btn.css("display", "none");
//                         edit_phone_btn.css('display', 'block');
//                         phone_btn.html('Change');
//                         cancel_edit_phone.css('display', 'none');
//                     }
//                 } else {  // Failed
//                     phoneMessage.addClass("error");
//                     phoneMessage.html(data.message)
//                     phone_btn.html('Verify');
//                 }
//                 phone_btn.attr("disabled", false);
//             },
//             error: function (data) { // Failed
//                 phoneMessage.addClass("error");
//                 phoneMessage.css('display','block');
//                 phoneMessage.html(data.responseJSON.message);
//                 phone_btn.attr("disabled", false);
//                 phone_btn.html('Change');
//             }
//         });
//     }
// });


// Update Profile
let message = $('#success-message');
const Error_Messages = ['username','name','gender','thought_of_the_day','bio'];
$(function () {
    $('#edit-profile-form').validate({
        rules: {
            name: "required",
            username: "required",
            gender: "required",
            bio: "required",
        },
        messages: {
            name: "Oops.! The name field is required.",
            username: "Oops.! The Username field is required.",
            gender: "Oops.! The Gender field is required.",
            bio: "Oops.! The Bio field is required.",
        },
        errorElement: 'p',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.grid-65').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (f) {
            clearErrors();
            var btn = $('#update-profile-btn'),
                form = $('#edit-profile-form');
            btn.attr('disabled', true);
            btn.val('Requesting');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function (data) {
                    // clearErrors();
                    if (parseInt(data.status) == 1) {
                        MessageShow('alert-success', data.message,'profile-setting');                        
                    } else {
                        MessageShow('alert-danger',data.message,'profile-setting');
                    }
                    btn.attr("disabled", false);
                    // form[0].reset();
                    btn.val('Update Profile');
                },
                error: function (data) {
                    // clearErrors();
                    $.each(data.responseJSON.errors, function (key, value) {
                        $(`#${key}` + "_error").css('display','block');
                        $(`#${key}` + "_error").html(value);
                    });
                    btn.attr("disabled", false);
                    btn.val('Update Profile');
                }
            });
            return false;
        }
    });
});


//Change Password validation
$(function (){
    $('#change-pass-form').validate(
    {
        rules: {
            old_password: "required",
            new_password: "required",
            confirm_password: "required",
        },
        messages: {
            old_password: "Oops.! The old password field is required.",
            new_password: "Oops.! The new password field is required.",
            confirm_password: "Oops.! The confirm password field is required.",
        },          
        errorElement: 'p',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.grid-65').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(f) {
            var btn = $('#change-pass-btn'), form = $('#change-pass-form');
            btn.attr('disabled', true) ;
            btn.val('Updating...');
            clearErrors(['old_password','new_password','confirm_password']);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    if(parseInt(data.status) == 1)
                    {
                        MessageShow('alert-success',data.message,'password-settings');
                    }else{
                        MessageShow('alert-danger',data.message,'password-settings');
                    }                     
                    btn.attr("disabled", false);
                    form[0].reset();                            
                    btn.val('Update');
                },
                error: function(data) {                    
                    if (data.responseJSON.message != "") {
                        MessageShow('alert-danger', data.responseJSON.message,'password-settings');
                    }
                    $.each(data.responseJSON.errors, function (key, value) {
                        $(`#${key}`+"_error").css('display','block');
                        $(`#${key}`+"_error").html(value);
                    });
                    btn.attr("disabled", false);
                    btn.val('Update');
                }
            });
            return false;
        }
    });
});

// Help Request
$(function (){
    $('#help-form').validate(
    {
        rules: {
            name: "required",
            email: "required",
            message: "required",
        },
        messages: {
            name: "Oops.! The old Name field is required.",
            email: "Oops.! The new Email field is required.",
            message: "Oops.! The  Message field is required.",
        },          
        errorElement: 'p',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.grid-65').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(f) {
            var btn = $('#help-btn'), form = $('#help-form');
            btn.attr('disabled', true) ;
            btn.val('Sending...');
            clearErrors(['email_help','name_help','phone_help','message_help']);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    if(parseInt(data.status) == 1)
                    {
                        MessageShow('alert-success',data.message,'help');
                    }else{
                        MessageShow('alert-danger',data.message,'help');
                    }                     
                    btn.attr("disabled", false);
                    form[0].reset();                            
                    btn.val('Send');
                },
                error: function(data) {                    
                    if (data.responseJSON.message != "") {
                        MessageShow('alert-danger', data.responseJSON.message,'help');
                    }
                    $.each(data.responseJSON.errors, function (key, value) {
                        $(`#${key}` + "_help_error").css('display','block');
                        $(`#${key}` + "_help_error").html(value);
                    });
                    btn.attr("disabled", false);
                    btn.val('Send');
                }
            });
            return false;
        }
    });
});


function clearErrors(error_messages="") {
    if (error_messages.length > 0) {
        $.each(error_messages, function (key, value) {
            $(`#${value}` + "_help_error").html("");
        }); 
    }else{
        $.each(Error_Messages, function (key, value) {
            $(`#${value}` + "_help_error").html("");
        });
    }
}

function MessageShow(addclass,msg,container) {
    $('#success-box').css('display', 'block');
    $(`main.setting#${container} .success-box`).css('display', 'block');
    $(`main.setting#${container} .success-box`).html(`<div class="alert ${addclass} alert-dismissible fade show" role="alert">
                                 <span id="success-message">${msg}</span>
                                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`);
    $(".active").scrollTop(0);
    setTimeout(function () {
        $(`main.setting#${container} .success-box`).css('display', 'none');
    }, 5000);
}

// Confirm Password (Delete Account)
$(function () {
    $('#delete_account_form').validate({
        rules: {
            password: "required",
        },
        messages: {
            password: "Oops.! The password field is required.",
        },
        errorElement: 'p',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.password_box').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (f) {
            $('.confirm_password_error_1').html("");
            var btn = $('#delete_account_submit'),
                form = $('#delete_account_form');
            btn.attr('disabled', true);
            btn.html('Requesting');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function (data) {
                    if (parseInt(data.status) == 1) {
                        deleteQuesContainer.innerHTML = `
                            <div class="feedback_box ">
                              <p class="delete-confirm-text">${data.message}</p>
                              <button type="button" class="d_btn" onclick="LogoutNow()">Close</button>
                            </div>
                          `;
                    } else {
                        $('.confirm_password_error_1').html(data.message)
                    }
                    btn.attr("disabled", false);
                    btn.html('Confirm Password');
                },
                error: function (data) {
                    $.each(data.responseJSON.errors, function (key, value) {
                        $('.confirm_password_error_1').html(value)
                    });
                    btn.attr("disabled", false);
                    btn.html('Confirm Password');
                }
            });
            return false;
        }
    });
});

// Update Profile Modal
function ProfileEditModal() {
    $('#profile_image_error').html("");
    var form = $('#change_profile_form');
    form[0].reset(); 
    $('#upload_profile_container').toggleClass('hide');    
}

// Profile Image Form
$(function () {
    $('#change_profile_form').validate({
        rules: {
            image: "required",
        },
        messages: {
            image: "Oops.! The image field is required.",
        },
        errorElement: 'p',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.profile-image-box').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (f) {
            $('#profile_image_error').html("");
            var btn = $('#change_profile_btn'),
                form = $('#change_profile_form');
            btn.attr('disabled', true);
            btn.val('Changing...');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function (data) {
                    if (parseInt(data.status) == 1) {
                        if (data.img) {  $('#user-photo').html(data.img);}
                        if (data.profileimage) {
                            $('.header-img-1').each(function(index,element) {
                                $(element).attr('src',data.profileimage);
                            });
                        }
                        ProfileEditModal();
                    } else {
                        $('#profile_image_error').html(data.message);
                    }
                    btn.attr("disabled", false);
                    form[0].reset();
                    btn.val('Update Profile');
                },
                error: function (data) {
                    // clearErrors();
                    $.each(data.responseJSON.errors, function (key, value) {
                        $('#profile_image_error').html(value);
                    });
                    btn.attr("disabled", false);
                    btn.val('Update Profile');
                }
            });
            return false;
        }
    });
});

// // Disable Space
// $(document).ready(function(){
//     const websiteInput = document.getElementById("website");
//     websiteInput.addEventListener("keydown", function(event) {
//         if (event.code === "Space") {
//         event.preventDefault();
//         }
//     });

//     websiteInput.addEventListener("paste", function(event) {
//         event.preventDefault();
//         const text = event.clipboardData.getData("text/plain");
//         const modifiedText = text.replace(/\s/g, "");
//         document.execCommand("insertText", false, modifiedText);
//     });
// });
// //Tabs Layout Code
// $("#tabs").tabs({
//     activate: function (event, ui) {
//         var active = $('#tabs').tabs('option', 'active');
//         $("#tabid").html('the tab id is ' + $("#tabs ul>li a").eq(active).attr("href"));
//     }
// });