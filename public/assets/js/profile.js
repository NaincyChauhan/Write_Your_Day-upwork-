// const overlayContainer = document.querySelector(".overlay_container");
const moreOptionToggle = document.querySelector(".more_option_toggle");
const blockBtn = document.querySelector("#block");
const messageBtn = document.querySelector(".message_btn");
const followFriendBtn = document.querySelector("#follow_friend_btn");

moreOptionToggle.onclick = () => overlayContainer.classList.remove("hide");

let unBlockUser = () => {
    followFriendBtn.textContent = "Follow"
    blockBtn.textContent = "Unblocked"
    setTimeout(() => blockBtn.textContent = "Block", 1500);
    messageBtn.removeAttribute("disabled", "disabled");
}

blockBtn.onclick = () => {
    if (blockBtn.textContent === "Block") {
        blockBtn.textContent = "Blocked";
        setTimeout(() => blockBtn.textContent = "Unblock", 1500);
        messageBtn.setAttribute("disabled", "disabled");
        followFriendBtn.textContent = "Unblock"
    } else {unBlockUser()}
    overlayContainer.classList.add("hide");
}

followFriendBtn.onclick = () => {
    if (followFriendBtn.textContent === "Follow") followFriendBtn.textContent = "Unfollow";
    else if (followFriendBtn.textContent === "Unblock") unBlockUser();
    else followFriendBtn.textContent = "Follow";
}
