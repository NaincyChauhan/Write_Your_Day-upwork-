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
        <input type="password" name="password" id="password_check">
        <i class="fa fa-eye-slash icon" ></i>
      </div>
      <p class="error" id="pwd_error"></p>
      <div class="d-flex justify-content-between mx-4">
        <button class="d_btn suggested_btn" onclick="checkPassword()">Confirm Password</button>
        <button class="d_btn" onclick="closeBox()">Cancel</button>
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
    let user = JSON.parse(sessionStorage.getItem("user-details"));
    let userPwd = user.password;
    let pwdField = document.querySelector("#password_check").value;
    let pwdError = document.querySelector("#pwd_error");

    if (userPwd !== pwdField) {
        pwdError.textContent = "Wrong Password";
        return;
    }

    deleteQuesContainer.innerHTML = `
    <div class="feedback_box ">
      <p class="feedback_txt">Your account has been deleted temporarily. You can recover it within 14 days else it will be permanetly deleted</p>
      <button class="d_btn" onclick="closeBox()">Close</button>
    </div>
  `;

}

let closeBox = () => {
    deleteQuesContainer.classList.add("hide");
    setTimeout(() => {
        deleteQuesContainer.innerHTML = `
    <div class="ques_box ">
      <p class="ques_txt ">Are you sure you want to delete this account?</p>
      <div class="d-flex justify-content-between mx-4">
        <button class="ques_btn" id="delete_btn" onclick="proceedDeletion()">Yes</button>
        <button class="ques_btn suggested_btn" onclick="closeBox()" >No</button>
      </div>
    </div>
  `
    }, 1000)
}

function ChangeUserEmail() {
    const userEmail = $('#user-email');
    let emailMessage = $('#email_message'),
        email_btn = $('#edit-email-btn');
    const email_opt_box = $('#email-otp-box');
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
            "email":userEmail.val(),
            "otp":email_opt_box.val(),
            "type": 1,
        },
        success: function(data) {
            if (parseInt(data.status) == 1) {    // Success
                emailMessage.addClass("text-success");
                emailMessage.html(data.message)
                if (parseInt(data.type)==0) {
                    email_opt_box.css("display","block");
                }
            } else {  // Failed
                emailMessage.addClass("error");
                emailMessage.html(data.message)
            }
            email_btn.attr("disabled", false);
            email_btn.html('Verify');
        },
        error: function(data) { // Failed
            $.each(data.responseJSON.errors, function(key, value) {
                emailMessage.html(value);
            });
            email_btn.attr("disabled", false);
            email_btn.html('Edit');
        }
    });
}

//Tabs Layout Code
$("#tabs").tabs({
    activate: function (event, ui) {
        var active = $('#tabs').tabs('option', 'active');
        $("#tabid").html('the tab id is ' + $("#tabs ul>li a").eq(active).attr("href"));
    }
});