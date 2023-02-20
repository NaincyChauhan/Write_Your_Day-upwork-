function LikePostRequest(id_,thisObj) {
    var form = $(`#like_post_form_${id_}`),
        // btn = $(`#like_post_btn_${id_}`);
        btn = thisObj;
    like_count = $(btn.find('.post_like_count')).html();
    btn.attr("disabled", true);
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            if (parseInt(data.status) == 1) {
                if (parseInt(data.type) == 0) {
                    // Unlike Heart
                    like_count--;
                    $(btn.find('.simple-heart')).show("fast");
                    $(btn.find('.red-heart')).hide();
                    $(btn.find('.post_like_count')).html(like_count);
                    // btn.html(`<img class="simple-heart" src="${window.location.origin}/assets/images/heart.png">
                    //             <span><span class="post_like_count">${like_count}</span> Likes</span>`);                   
                    showLikeMessage(data.message);
                }
                if (parseInt(data.type) == 1) {
                    // Like Heart
                    like_count++;
                    $(btn.find('.red-heart')).show("fast");
                    $(btn.find('.simple-heart')).hide();
                    $(btn.find('.post_like_count')).html(like_count);
                    // btn.html(`<img class="red-heart d-block" src="${window.location.origin}/assets/images/red-heart.png">
                    //             <span><span class="post_like_count">${like_count}</span> Likes</span>`);     
                    showLikeMessage(data.message);

                }
            } else {
                showLikeMessage(data.message);
            }
            btn.attr("disabled", false);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                console.error("error", value);
            });
            btn.attr("disabled", false);
        }
    });
}

function showLikeMessage(message_) {
    $('#like-popup').html(`<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div id="liveToast" style="width: 160px;" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body" style="font-size: 14px; font-weight: 500;">
                            ${message_}
                        </div>
                    </div>
                </div>`);

    setTimeout(function () {
        $('#like-popup').html("");
    }, 10000);
}

function sharePostRequest(id_) {
    var form = $(`#share_post_form_${id_}`),
        btn = $(`#share_post_btn_${id_}`);
    SharePostModal(id_);
    btn.attr("disabled", true);
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            btn.attr("disabled", false);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                console.error("error", value);
            });
            btn.attr("disabled", false);
        }
    });
}

// Show Share Modal
function SharePostModal(id_) {
    $(`#share_post_container_${id_}`).toggleClass('hide');
}

// Like Comment
function LikeCommentRequest(id_) {
    var form = $(`#like_comment_form_${id_}`),
        btn = $(`#like_comment_btn_${id_}`);
    like_count = $(form.find('.comment_like_count')).html();
    btn.attr("disabled", true);
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            if (parseInt(data.status) == 1) {
                if (parseInt(data.type) == 0) {
                    // Unlike Heart
                    like_count--;
                    $(form.find('.red-heart')).hide();
                    btn.html(`<img class="simple-heart -c-d-n" src="${window.location.origin}/assets/images/heart.png">
                    <span><span class="comment_like_count">${like_count}</span> Likes</span>`);
                    $(form.find('.simple-heart')).show("fast");
                    showLikeMessage(data.message);
                }
                if (parseInt(data.type) == 1) {
                    // Like Heart
                    like_count++;
                    // $(form.find('.simple-heart')).hide();      
                    btn.html(`<img class="red-heart" src="${window.location.origin}/assets/images/red-heart.png">
                                <span><span class="comment_like_count">${like_count}</span> Likes</span>`);
                    $(form.find('.red-heart')).show("fast");
                    showLikeMessage(data.message);

                }
            } else {
                showLikeMessage(data.message);
            }
            btn.attr("disabled", false);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                console.error("error", value);
            });
            btn.attr("disabled", false);
        }
    });
}

// Save Post 
function SavePostRequest(id_) {
    var form = $(`#save_post_form_${id_}`),
        btn = $(`#save_post_btn_${id_}`);
    btn.attr("disabled", true);
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            if (parseInt(data.status) == 1) {
                if (parseInt(data.type) == 0) {
                    // Remove From Save
                    btn.html(`<img style="margin-bottom: -8px;" class="red-heart d-block" src="${window.location.origin}/assets/images/bookmark.png" />`);
                    showLikeMessage(data.message);
                }
                if (parseInt(data.type) == 1) {
                    // Add To Save
                    btn.html(`<img style="margin-bottom: -8px;" class="red-heart d-block" src="${window.location.origin}/assets/images/bookmark-blue.png" />`);
                    showLikeMessage(data.message);

                }
            } else {
                showLikeMessage(data.message);
            }
            btn.attr("disabled", false);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                console.error("error", value);
            });
            btn.attr("disabled", false);
        }
    });
}


// Follow, UnFollow user 
function FollowUnFollowRequest(id_, thisObj) {
    console.log("function is running well", id_);
    var form = $(`#follow_unfollow_user_form_${id_}`),
        btn = thisObj;
    btn.attr("disabled", true);
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            if (parseInt(data.status) == 1) {
                btn.html(data.message);
                console.log(data.message);
            } else {
                showLikeMessage(data.message);
                console.log(data.message);
            }
            btn.attr("disabled", false);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                console.error("error", value);
            });
            btn.attr("disabled", false);
        }
    });
}

// Remove From Follower List
function RemoverFromFollower(id_, thisObj) {
    console.log("function is running well define");
    // return
    var form = $(`#remove_follower_user_form_${id_}`),
        btn = thisObj;
    btn.attr("disabled", true);
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            if (parseInt(data.status) == 1) {
                $(`#remove_follower_user_container_${id_}`).html("");
            } else {
                showLikeMessage(data.message);
            }
            btn.attr("disabled", false);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                console.error("error", value);
            });
            btn.attr("disabled", false);
        }
    });
}

function ShowPostReportModal(id_) {
    console.log($(`#report_post_container_${id_}`));
    $(`#report_post_container_${id_}`).toggleClass('hide');
}

function ShowReportModal(id_) {
    console.log("function is running well define here", id_);
    form = $('#post-report-form');
    $(form.find('#report_post_id')).val(id_);
    $('#report_msg_container').toggleClass('hide');
}

// Post Report
//  User Comment Function
$(function () {
    $('#post-report-form').validate({
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
            var form = $('#post-report-form'),
                btn = $('#send_report');
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
                    $('#report_msg_container').toggleClass('hide');
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

function HidePostRequest(id_,btn) {
    var form = $(`#hide_post_form_${id_}`);
    btn.attr('disabled', true);
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            showLikeMessage(data.message);
            btn.attr("disabled", false);
            $(`#post_container_${id_}`).html("");
            $(`#post_container_${id_}`).css('display','none');
        },
        error: function (data) {
            showLikeMessage(data.responseJSON.messages);
            btn.attr("disabled", false);
            btn.html('Send');
        }
    });
}