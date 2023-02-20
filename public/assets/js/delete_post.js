// Delete Post Modal
function ShowDeleteModal(id_) {
    $(`#delete_post_container_${id_}`).toggleClass('hide');    
}

// Delete Post
function DeletePostRequest(id_) {
    var form = $(`#delete_post_form_${id_}`),
        btn = $(`#delete_post_btn_${id_}`);
    btn.attr("disabled", true);
    btn.html("Deleting...");
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: form.attr('action'),
        data: new FormData(form[0]), // serializes the form's elements.
        success: function (data) {
            ShowDeleteModal(id_)
            if (parseInt(data.status) == 1) {
                $(`#main_post_container_${id_}`).html("");
                showLikeMessage(data.message);
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