const msgExtrasBtn = document.querySelectorAll('.msg_extras_btn');
const msgExtrasList = document.querySelectorAll('.msg_extras_list');
const reportContainer = document.querySelector(".report_msg_container");
const reportMsg = document.querySelector("#report_msg");
const sendReportBtn = document.querySelector("#send_report");
const postOwners = document.querySelectorAll(".post_owner");
const reportBtns = document.querySelectorAll(".report");
const msgError = document.querySelector(".msg_error");
const followBtns = document.querySelectorAll(".follow_btn");
const friendName = document.querySelector("#friend_name");
const followersLink = document.querySelectorAll(".followers_link");
const followersContainer = document.querySelector(".followers_container");
const followingLink = document.querySelectorAll(".following_link");
const followingContainer = document.querySelector(".following_container");
const removeBtns = document.querySelectorAll(".remove_btn");


for (let msgBtnIndex = 0; msgBtnIndex < msgExtrasBtn.length; msgBtnIndex++) {
    msgExtrasBtn[msgBtnIndex].onclick = () => {
        if (msgExtrasList[msgBtnIndex].classList.contains("hide")) {
            msgExtrasList[msgBtnIndex].classList.remove("hide");
            return;
        }
        msgExtrasList[msgBtnIndex].classList.add("hide");
    }
}
document.body.onclick = (e) => {
    if (!(e.target.classList.contains("msg_extras_btn") || e.target.classList.contains("caret"))) {
        for (let msgBtnIndex = 0; msgBtnIndex < msgExtrasList.length; msgBtnIndex++) {
            if (!msgExtrasList[msgBtnIndex].classList.contains("hide")) msgExtrasList[msgBtnIndex].classList.add("hide");
        }
    }

}

for (let reportBtnIndex = 0; reportBtnIndex < reportBtns.length; reportBtnIndex++) {
    reportBtns[reportBtnIndex].addEventListener('click', () => {
        if (overlayContainer) overlayContainer.classList.add("hide")
        reportContainer.classList.remove("hide");
        if (postOwners[reportBtnIndex]) reportMsg.placeholder = `What's wrong with ${postOwners[reportBtnIndex].textContent } post?`;
        if (friendName) reportMsg.placeholder = `What did ${friendName.textContent } do?`;
    });
}

sendReportBtn.onclick = () => {
    if (reportMsg.value === "") {
        msgError.textContent = "Your report message is required";
        return;
    }
    sendReportBtn.innerHTML = `Sending <i class="fa fa-spinner fa-spin"></i>`;
    setTimeout(() => {
        sendReportBtn.innerHTML = `Sent <i class="fa fa-check"></i>`;
    }, 1500);
    setTimeout(() => {
        sendReportBtn.innerHTML = `Sent <i class="fa fa-check"></i>`;
    }, 1000);
    setTimeout(() => {
        reportContainer.classList.add("hide");
    }, 1000);
}


followBtns.forEach(followBtn => {
    followBtn.onclick = () => {
        if (followBtn.textContent === "Follow") followBtn.textContent = "Following"; 
        else followBtn.textContent = "Follow";
    }
});


followersLink.forEach(link => link.onclick = () => followersContainer.classList.remove("hide"));
followingLink.forEach(link => link.onclick = () => followingContainer.classList.remove("hide"));

for (let i = 0; i < removeBtns.length; i++) {
   removeBtns[i].onclick = () => {
       removeBtns[i].parentNode.parentNode.removeChild(removeBtns[i].parentNode)
   }; 
}

