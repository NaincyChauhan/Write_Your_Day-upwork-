// Add View Script
function AddView(url, post_id, post_type) {
    $.ajax({
        type: "GET",
        contentType: JSON,
        url: url,
        data: {
            "post_id": post_id,
            "post_type": post_type,
        }, // serializes the form's elements.
        success: function (data) {
            console.log("Success", data);
        },
        error: function (data) {
            console.log("error", data);
        }
    });
}

//  User Comment Function
$(function () {
    $('#comment-form').validate({
        rules: {
            content: "required",
        },
        messages: {
            content: "Oops.! The Contend field is required.",
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.comment-form-box').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (f) {
            sendCommentRequest('comment-submit', 'comment-form');
            return false;
        }
    });
});

function sendCommentRequest(btn, form_) {
    var btn = $(`#${btn}`),
        form = $(`#${form_}`);
    var commentError = form.find('.comment-error');
    var user_comment = form.find('.content');
    btn.attr('disabled', true);
    btn.html('Posting...');
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            $(user_comment).val("");
            $('#all-post-comments').append(data);
            btn.attr("disabled", false);
            btn.html('Post');
        },
        error: function (data) {
            $(commentError).html(data.responseJSON.errors.content);
            btn.attr("disabled", false);
            btn.html('Post');
        }
    });
}

function showReplyBox(id_) {
    $(`#reply-comment-box-${id_}`).css('display', 'block');
    $(`#reply-comment-box-${id_}`).toggleClass('toogle-reply');
}

function CommentReply(id_) {
    const form = $(`#reply-comment-form-${id_}`);
    const btn = $(`#reply-comment-btn-${id_}`);
    var commentError = form.find('.comment-error');
    var user_comment = form.find('.reply-content');
    if ($(user_comment).val().length == "") {
        $(commentError).html("Comment Field is required.");
        return false;
    }
    btn.attr('disabled', true);
    btn.html('Posting...');
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            $(user_comment).val("");
            $(`#reply-comment-box-${id_}`).css('display', 'none');
            $(`#reply-comment-box-${id_}`).toggleClass('toogle-reply');
            $(`#writereply-box-${id_}`).prepend(data);
            btn.attr("disabled", false);
            btn.html('Post');
        },
        error: function (data) {
            $(commentError).html(data.responseJSON.errors.content);
            btn.attr("disabled", false);
            btn.html('Post');
        }
    });
    return false;
}

//  User Comment Function
$(function () {
    $('#load-more-comment').validate({
        submitHandler: function (f) {
            // sendCommentRequest('comment-submit','comment-form');
            btn.attr('disabled', true);
            btn.html('Posting...');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function (data) {
                    $(user_comment).val("");
                    $(`#reply-comment-box-${id_}`).css('display', 'none');
                    $(`#reply-comment-box-${id_}`).toggleClass('toogle-reply');
                    $(`#writereply-box-${id_}`).prepend(data);
                    btn.attr("disabled", false);
                    btn.html('Post');
                },
                error: function (data) {
                    $(commentError).html(data.responseJSON.errors.content);
                    btn.attr("disabled", false);
                    btn.html('Post');
                }
            });
            return false;
            return false;
        }
    });
});

function loadCommentAndReply(id_,container_,loading_) {
    var load_more_btn = $(`#${id_}`);
    var postId = load_more_btn.data('post-id');
    var postType = load_more_btn.data('post-type');
    var parentId = load_more_btn.data('parent-id');
    var offset = load_more_btn.data('offset');
    var limit = load_more_btn.data('limit');
    // send an AJAX request to retrieve the comments and replies
    $(`#${loading_}`).css('display','block');
    $.ajax({
        url: `${window.location.origin}/load/comments`,
        type: 'GET',
        data: {
            post_id: postId,
            post_type: postType,
            parent_id: parentId,
            offset: offset,
            limit: limit
        },
        success: function (data) {
            $(`#${loading_}`).css('display','none');
            $(`#${container_}`).append(data);
            $(`#${id_}`).data('offset', offset + limit)
            var directChildren = $(`${data} > div.review-detail-comment-box-outer:not(:has(div.review-detail-comment-box-outer))`).length;
            if (directChildren < limit) {
                load_more_btn.hide();
            }
        }, error: function (data) {
            $(`#${loading_}`).css('display','none');
        }
    });

}

function printPost() {
    var postContent = document.getElementById('post-detail-main-container');
    var printWindow = window.open('', '', 'height=1240,width10600');
    // printWindow.document.write('<html><head>');
    // printWindow.document.write($('head').html);
    // printWindow.document.write('</head><body>');
    printWindow.document.write(postContent);
    // printWindow.document.write('</body></html>');
    printWindow.document.close();
    // printWindow.focus();
    printWindow.print();
    // printWindow.close();
  }